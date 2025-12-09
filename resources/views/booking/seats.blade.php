<x-app-layout>
    
    <div class="flex flex-col min-h-screen">

        <div class="bg-white border-b border-gray-200 shadow-sm relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center justify-center space-x-6 text-sm font-medium">
                    
                    <div class="flex items-center text-[#001233]">
                        <div class="p-1 bg-[#001233] rounded-full text-white mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <span class="font-bold border-b-2 border-[#001233] pb-0.5">Trip Details</span>
                    </div>
                    
                    <span class="text-gray-300">/</span>
                    
                    <div class="flex items-center text-gray-400">
                        <div class="p-1 border border-gray-300 rounded-full mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <span>Reservation Details</span>
                    </div>

                    <span class="text-gray-300">/</span>

                    <div class="flex items-center text-gray-400">
                        <div class="p-1 border border-gray-300 rounded-full mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span>Confirm Booking</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="flex items-center gap-12">
                        <div class="text-center md:text-left">
                            <h3 class="text-3xl font-black text-[#001233]">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}</h3>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Departure</p>
                        </div>
                        <div class="flex items-center gap-8">
                            <span class="text-xl font-bold text-[#001233]">{{ $schedule->route->origin }}</span>
                            <svg class="w-6 h-6 text-[#001233]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            <span class="text-xl font-bold text-[#001233]">{{ $schedule->route->destination }}</span>
                        </div>
                    </div>
                    
                    <div class="text-right">
                        <span class="text-3xl font-bold text-[#001233]">PHP {{ number_format($schedule->route->price, 2) }}</span>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Per Passenger</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-grow py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="w-full lg:w-2/3 bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                        <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
                            <h4 class="font-bold text-[#001233] text-lg">Select your seat(s) here.</h4>
                            <div class="flex gap-4 text-xs font-bold text-gray-500">
                                <div class="flex items-center gap-2"><div class="w-3 h-3 rounded bg-white border-2 border-gray-300"></div> Available</div>
                                <div class="flex items-center gap-2"><div class="w-3 h-3 rounded bg-gray-400"></div> Reserved</div>
                                <div class="flex items-center gap-2"><div class="w-3 h-3 rounded bg-[#10B981]"></div> Selected</div>
                            </div>
                        </div>
                        
                        <div class="bg-[#F3F4F6] p-10 rounded-2xl border border-gray-200 max-w-md mx-auto relative">
                            <div class="absolute top-4 left-1/2 transform -translate-x-1/2">
                                <span class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Front (Driver)</span>
                            </div>

                            <div class="grid grid-cols-5 gap-4 mt-6">
                                @for($i = 1; $i <= $schedule->bus->capacity; $i++)
                                    @php $isTaken = in_array($i, $takenSeats); @endphp
                                    
                                    @if($i % 4 == 3 && $i > 1) <div></div> @endif

                                    <button 
                                        onclick="toggleSeat({{ $i }})"
                                        id="seat-{{ $i }}"
                                        {{ $isTaken ? 'disabled' : '' }}
                                        class="h-12 w-12 rounded-lg font-bold text-sm transition border-2 flex items-center justify-center shadow-sm
                                        {{ $isTaken 
                                            ? 'bg-gray-300 text-gray-100 cursor-not-allowed border-transparent' 
                                            : 'bg-white text-gray-600 border-gray-300 hover:border-[#10B981] hover:text-[#10B981]' 
                                        }}">
                                        {{ $isTaken ? 'X' : $i }}
                                    </button>
                                @endfor
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/3">
                        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 sticky top-24">
                            
                            <div class="flex justify-between items-center mb-6">
                                <span class="text-sm font-medium text-gray-500">Pick-up Time</span>
                                <span class="font-black text-[#001233] text-lg">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}</span>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase mb-1 block tracking-wider">Pick-up</label>
                                    <div class="flex items-center justify-between w-full px-4 py-3 rounded-lg border border-gray-300 bg-white text-[#001233] font-bold shadow-sm">
                                        <span class="truncate">{{ $schedule->route->origin }}</span>
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-[10px] text-gray-400 font-bold uppercase mb-1 block tracking-wider">Drop-off</label>
                                    <div class="flex items-center justify-between w-full px-4 py-3 rounded-lg border border-gray-300 bg-white text-[#001233] font-bold shadow-sm">
                                        <span class="truncate">{{ $schedule->route->destination }}</span>
                                        <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-2 mb-6 pt-6 border-t border-dashed border-gray-200">
                                <div class="flex justify-between items-start text-sm text-gray-600">
                                    <span class="shrink-0">Seat(s) Selected</span>
                                    <span id="selected-seats-display" class="font-bold text-[#001233] text-right max-w-[60%] leading-tight">-</span>
                                </div>
                                <div class="flex justify-between text-sm text-gray-600">
                                    <span>Fare Per Seat</span>
                                    <span class="font-bold text-[#001233]">PHP {{ number_format($schedule->route->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-end border-t border-gray-200 pt-4 mt-2">
                                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Total Fare</span>
                                    <span id="total-price" class="font-black text-2xl text-[#001233]">PHP 0.00</span>
                                </div>
                            </div>

                            <form action="{{ route('booking.details') }}" method="POST">
                                @csrf
                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                <input type="hidden" name="seats" id="selected-seats-input">
                                
                                <button type="submit" id="proceed-btn" disabled 
                                        class="w-full py-3.5 bg-gray-200 text-gray-400 font-bold rounded-lg cursor-not-allowed transition uppercase text-xs tracking-widest hover:shadow-lg">
                                    Reserve Seat/s
                                </button>
                            </form>

                            <div class="mt-4 text-center">
                                <a href="{{ route('dashboard', [
                                    'origin' => $schedule->route->origin, 
                                    'destination' => $schedule->route->destination, 
                                    'date' => \Carbon\Carbon::parse($schedule->departure_time)->format('Y-m-d')
                                ]) }}" class="inline-flex items-center gap-2 text-xs font-bold text-gray-400 hover:text-red-500 transition uppercase tracking-wide group">
                                    <svg class="w-4 h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Cancel Booking
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>

        <footer class="bg-[#001233] text-white py-6 mt-auto">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <p class="text-sm">© 2025 BusPH. All rights reserved.</p>
            </div>
        </footer>

    </div>

    <script>
        let selectedSeats = [];
        const pricePerSeat = {{ $schedule->route->price }};

        function toggleSeat(seatNum) {
            const btn = document.getElementById(`seat-${seatNum}`);
            
            if (selectedSeats.includes(seatNum)) {
                // DESELECT
                selectedSeats = selectedSeats.filter(s => s !== seatNum);
                // Reset styles
                btn.classList.remove('bg-[#10B981]', 'text-white', 'border-[#10B981]', 'shadow-md', 'scale-105');
                btn.classList.add('bg-white', 'text-gray-600', 'border-gray-300');
            } else {
                // SELECT
                selectedSeats.push(seatNum);
                // Apply green styles
                btn.classList.remove('bg-white', 'text-gray-600', 'border-gray-300');
                btn.classList.add('bg-[#10B981]', 'text-white', 'border-[#10B981]', 'shadow-md', 'scale-105');
            }

            updateSummary();
        }

        function updateSummary() {
            const count = selectedSeats.length;
            const total = count * pricePerSeat;

            // Update UI Text (With Truncation Logic)
            const displayElement = document.getElementById('selected-seats-display');
            
            if (count > 0) {
                // Sort seats numerically for better readability (e.g., "1, 2, 10" instead of "1, 10, 2")
                selectedSeats.sort((a, b) => a - b);

                if (count > 5) {
                    // If more than 5 seats, truncate: "1, 2, 3, 4, 5 + 3 more"
                    const firstFew = selectedSeats.slice(0, 5).join(', ');
                    const remaining = count - 5;
                    displayElement.innerText = `${firstFew} + ${remaining} more`;
                } else {
                    // Otherwise show all
                    displayElement.innerText = selectedSeats.join(', ');
                }
            } else {
                displayElement.innerText = '-';
            }

            // Update Price and Input
            document.getElementById('total-price').innerText = 'PHP ' + total.toLocaleString('en-US', {minimumFractionDigits: 2});
            document.getElementById('selected-seats-input').value = selectedSeats.join(',');

            // Button State
            const btn = document.getElementById('proceed-btn');
            if (count > 0) {
                btn.disabled = false;
                btn.classList.remove('bg-gray-200', 'text-gray-400', 'cursor-not-allowed');
                btn.classList.add('bg-[#001233]', 'text-white', 'hover:bg-blue-900', 'shadow-lg');
            } else {
                btn.disabled = true;
                btn.classList.add('bg-gray-200', 'text-gray-400', 'cursor-not-allowed');
                btn.classList.remove('bg-[#001233]', 'text-white', 'hover:bg-blue-900', 'shadow-lg');
            }
        }
    </script>
</x-app-layout>