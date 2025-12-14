<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- PROGRESS BAR --}}
            <div class="mb-8">
                <div class="flex items-center justify-center space-x-4">
                    <div class="flex items-center text-[#001233]">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#001233] text-white font-bold text-sm">1</span>
                        <span class="ml-2 font-medium text-sm hidden sm:block">Trip Details</span>
                    </div>
                    <div class="w-16 h-0.5 bg-[#001233]"></div>
                    <div class="flex items-center text-[#001233]">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#001233] text-white font-bold text-sm">2</span>
                        <span class="ml-2 font-medium text-sm hidden sm:block">Passenger Info</span>
                    </div>
                    <div class="w-16 h-0.5 bg-[#001233]"></div>
                    <div class="flex items-center text-[#001233]">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-[#001233] text-white font-bold text-sm">3</span>
                        <span class="ml-2 font-bold text-sm hidden sm:block">Confirm</span>
                    </div>
                </div>
            </div>

            <form action="{{ route('booking.payment') }}" method="POST" id="confirm">
                @csrf
                {{-- HIDDEN INPUTS: PASS DATA TO NEXT STEP --}}
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                <input type="hidden" name="seats" value="{{ implode(',', $selectedSeats) }}">
                <input type="hidden" name="contact_phone" value="{{ $validated['contact_phone'] }}">
                <input type="hidden" name="contact_email" value="{{ $validated['contact_email'] }}">

                {{-- Loop to pass passenger array data --}}
                @foreach($validated['passengers'] as $index => $p)
                    <input type="hidden" name="passengers[{{ $index }}][first_name]" value="{{ $p['first_name'] }}">
                    <input type="hidden" name="passengers[{{ $index }}][surname]" value="{{ $p['surname'] }}">
                    <input type="hidden" name="passengers[{{ $index }}][discount_id]" value="{{ $p['discount_id'] ?? '' }}">
                @endforeach

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- LEFT COLUMN: REVIEW DETAILS --}}
                    <div class="lg:col-span-2 space-y-6">
                        
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h2 class="text-xl font-bold text-[#001233] mb-4 border-b pb-2">Review Your Booking</h2>
                            
                            {{-- Contact Info --}}
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Contact Email</p>
                                    <p class="font-medium text-gray-900">{{ $validated['contact_email'] }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500 uppercase font-bold">Contact Number</p>
                                    <p class="font-medium text-gray-900">{{ $validated['contact_phone'] }}</p>
                                </div>
                            </div>

                            {{-- Passenger List --}}
                            <h3 class="font-bold text-gray-700 mb-3">Passenger List</h3>
                            <div class="space-y-3">
                                @foreach($validated['passengers'] as $index => $passenger)
                                    <div class="bg-gray-50 p-4 rounded-lg flex justify-between items-center">
                                        <div>
                                            <p class="font-bold text-[#001233]">
                                                {{ $passenger['first_name'] }} {{ $passenger['surname'] }}
                                            </p>
                                            @if(!empty($passenger['discount_id']))
                                                <p class="text-xs text-blue-600 font-semibold">
                                                    Discount ID: {{ $passenger['discount_id'] }}
                                                </p>
                                            @else
                                                <p class="text-xs text-gray-500">Regular Fare</p>
                                            @endif
                                        </div>
                                        <div class="text-right">
                                            <span class="bg-[#001233] text-white text-xs px-2 py-1 rounded">
                                                Seat {{ $selectedSeats[$index] }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- RIGHT COLUMN: SUMMARY --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 sticky top-4">
                            <h3 class="text-xl font-bold text-[#001233] mb-6 border-b pb-4">Trip Summary</h3>
                            
                            <div class="mb-6">
                                <span class="text-gray-500 font-bold text-xs uppercase tracking-wider block mb-1">Route</span>
                                <div class="font-bold text-gray-800 text-lg">
                                    {{ $schedule->route->origin }} 
                                    <span class="text-gray-400 mx-1">→</span> 
                                    {{ $schedule->route->destination }}
                                </div>
                            </div>

                            <div class="mb-6">
                                <span class="text-gray-500 font-bold text-xs uppercase tracking-wider block mb-1">Schedule</span>
                                <div class="font-bold text-gray-800">
                                    {{ \Carbon\Carbon::parse($schedule->departure_time)->format('M d, Y') }}
                                    <span class="block text-sm text-gray-600">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <span class="text-gray-500 font-bold text-xs uppercase tracking-wider block mb-1">Seats</span>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($selectedSeats as $seat)
                                        <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs font-bold border border-gray-200">{{ $seat }}</span>
                                    @endforeach
                                </div>
                            </div>

                            <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Seat Amount</span>
                                    <span class="text-2xl font-black text-[#001233]">₱ {{ number_format($totalPrice, 2) }}</span>
                                </div>
                                
                                <button type="submit" class="w-full bg-[#001233] text-white py-3 rounded-lg font-bold hover:bg-blue-900 transition mt-4 shadow-lg flex justify-center items-center gap-2">
                                    Proceed to Payment
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                </button>
                                
                                <button type="button" onclick="history.back()" class="w-full mt-3 text-gray-500 text-sm hover:text-gray-700 underline">
                                    Go Back & Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

{{-- IMPORTANT!!! --}}
{{-- Remove this part when integrating a real payment gateway --}}
<script>
    document.getElementById('confirm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = this.querySelector('button');
        btn.disabled = true;
        btn.innerHTML = `<svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...`;
        btn.classList.add('bg-gray-800', 'cursor-not-allowed');
        setTimeout(() => {
            this.submit();
        }, 2000);
    });
</script>