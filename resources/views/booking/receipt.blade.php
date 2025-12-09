<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Public back link --}}
            <a href="{{ route('user.bookings.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-[#001233] mb-6 transition">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to My Bookings
            </a>
            
                
                <div id="print-area">
                    @include('shared.receipt-content', ['reservation' => $reservation])
                </div>


            {{-- CANCELLATION BUTTON/FORM SECTION --}}
            @php
                $canCancel = \Carbon\Carbon::parse($reservation->schedule->departure_time)->isFuture() && $reservation->cancellation_status === 'none';
                $isPending = $reservation->cancellation_status === 'pending';
                $isRejected = $reservation->cancellation_status === 'rejected';
            @endphp

            <div class="mt-12 p-6 bg-white rounded-xl shadow-lg border border-gray-100 print:hidden">
                <h3 class="text-xl font-bold text-red-600 mb-4">Cancellation Request</h3>

                @if ($isPending)
                    <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded-lg shadow-sm">
                        This cancellation request is currently **PENDING REVIEW** by the administrator.
                    </div>
                @elseif ($isRejected)
                    <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-sm">
                        This cancellation request was **REJECTED** by the administrator. Your booking remains active.
                    </div>
                @elseif (!$canCancel)
                     <div class="bg-gray-50 border-l-4 border-gray-500 text-gray-700 p-4 rounded-lg shadow-sm">
                        This booking is complete or the cancellation window has passed.
                    </div>
                @elseif ($canCancel)
                    {{-- Only display the actionable button if user can cancel --}}
                    <div class="flex justify-between items-center">
                        <p class="text-gray-700">Click below to submit your cancellation request for admin approval.</p>
                        
                        <button type="button" onclick="openCancellationModal({{ $reservation->id }})"
                                class="bg-red-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-red-700 transition flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Cancel Booking
                        </button>
                    </div>
                @endif

                {{-- Print Button (Always visible outside the main cancellation logic) --}}
                <div class="mt-4 flex justify-end">
                    <button onclick="window.print()" class="bg-gray-200 text-gray-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-300 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m4 0v-4a2 2 0 012-2h2a2 2 0 012 2v4m-8 0h8"></path></svg>
                        Print Receipt
                    </button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>

<style>
@media print {

    /* FORCE A4 ONE-PAGE */
    @page {
        size: A4 portrait;
        margin: 0 !important;
    }

    /* Hide everything except receipt */
    body * {
        visibility: hidden !important;
    }

    #print-area, #print-area * {
        visibility: visible !important;
    }

    /* Position receipt to fit A4 */
    #print-area {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        margin: 0 auto;
        width: 100%;
        padding: 10mm; /* reduced padding */
        box-sizing: border-box;
        transform: scale(0.90);   /* shrink to fit */
        transform-origin: top center;
    }

    /* Prevent any element from breaking onto next page */
    #print-area * {
        page-break-inside: avoid !important;
        break-inside: avoid !important;
    }

    /* Ensure dark sections print properly */
    .print-dark {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }
}
</style>

