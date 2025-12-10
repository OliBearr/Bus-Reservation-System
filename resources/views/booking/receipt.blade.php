<x-app-layout>
    {{-- PRINT STYLES --}}
    <style>
        @media print {
            @page { size: A4 portrait; margin: 0 !important; }
            body * { visibility: hidden !important; }
            #print-area, #print-area * { visibility: visible !important; }
            #print-area {
                position: absolute; top: 0; left: 0; right: 0; margin: 0 auto; width: 100%;
                padding: 10mm; background-color: white; transform: scale(0.9); transform-origin: top center;
            }
            .print\:hidden { display: none !important; }
        }
    </style>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Validation Error Alert --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif

            <a href="{{ route('user.bookings.index') }}" class="print:hidden inline-flex items-center text-sm text-gray-500 hover:text-[#001233] mb-6 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to My Bookings
            </a>

            <div id="print-area">
                @include('shared.receipt-content', ['reservation' => $reservation])
            </div>

            {{-- CANCELLATION SECTION --}}
            @php
                $canCancel = \Carbon\Carbon::parse($reservation->schedule->departure_time)->isFuture() && $reservation->cancellation_status === 'none';
                $isPending = $reservation->cancellation_status === 'pending';
                $isRejected = $reservation->cancellation_status === 'rejected';
            @endphp

            <div class="print:hidden mt-12 p-6 bg-white rounded-xl shadow-lg border border-gray-100">
                <h3 class="text-xl font-bold text-red-600 mb-4">Cancellation Request</h3>

                @if ($isPending)
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg">
                        <p class="font-bold">Request Pending</p>
                        <p>Currently under review.</p>
                    </div>
                @elseif ($isRejected)
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                        <p class="font-bold">Request Rejected</p>
                    </div>
                @elseif (!$canCancel)
                     <div class="bg-gray-50 border-l-4 border-gray-500 text-gray-700 p-4 rounded-lg">
                        Booking complete or past cancellation window.
                    </div>
                @elseif ($canCancel)
                    <form method="POST" action="{{ route('user.bookings.cancel', $reservation->id) }}" class="space-y-4">
                        @csrf
                        <p class="text-gray-700">Are you sure you want to cancel this booking?</p>
                        
                        <div>
                            <label for="cancellation_reason" class="block text-sm font-bold text-gray-700 mb-2">
                                Reason for Cancellation (Required)
                            </label>
                            <textarea name="cancellation_reason" id="cancellation_reason" rows="4" 
                                      class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" 
                                      required></textarea>
                        </div>

                        <div class="flex justify-end gap-3 pt-2">
                            <button type="button" onclick="window.print()" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition">
                                Print Receipt
                            </button>
                            <button type="submit" class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition">
                                Request Cancellation
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>