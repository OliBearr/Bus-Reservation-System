<x-app-layout>
    <div class="flex flex-col min-h-screen">
        
        <div class="bg-white border-b border-gray-200 shadow-sm relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center justify-center space-x-6 text-sm font-medium">
                    
                    <a href="{{ route('dashboard', [
                        'origin' => $schedule->route->origin, 
                        'destination' => $schedule->route->destination, 
                        'date' => \Carbon\Carbon::parse($schedule->departure_time)->format('Y-m-d')
                    ]) }}" class="flex items-center text-green-600 hover:text-green-800 transition cursor-pointer group">
                        <div class="p-1 border border-green-600 rounded-full mr-2 group-hover:bg-green-600 group-hover:text-white transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Trip Details</span>
                    </a>
                    
                    <span class="text-gray-300">/</span>
                    
                    <div class="flex items-center text-[#001233]">
                        <div class="p-1 bg-[#001233] rounded-full text-white mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <span class="font-bold border-b-2 border-[#001233] pb-0.5">Reservation Details</span>
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

        <div class="py-12 flex-grow">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="w-full lg:w-2/3">
                        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                                <h3 class="text-xl font-bold text-[#001233]">Passenger Information</h3>
                                <a href="{{ route('dashboard', [
                                    'origin' => $schedule->route->origin, 
                                    'destination' => $schedule->route->destination, 
                                    'date' => \Carbon\Carbon::parse($schedule->departure_time)->format('Y-m-d')
                                ]) }}" class="text-sm text-red-500 hover:text-red-700 hover:underline font-medium flex items-center gap-1 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Cancel Booking
                                </a>
                            </div>
                            
                            <form action="{{ route('booking.confirm') }}" method="POST"> 
                                @csrf
                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                <input type="hidden" name="seats" value="{{ implode(',', $selectedSeats) }}">

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Full Name</label>
                                        <input type="text" name="passenger_name" value="{{ Auth::user()->name }}" 
                                               class="w-full rounded-lg border-gray-300 focus:border-[#001233] focus:ring-[#001233]" required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Email Address</label>
                                        <input type="email" name="passenger_email" value="{{ Auth::user()->email }}" 
                                               class="w-full rounded-lg border-gray-300 focus:border-[#001233] focus:ring-[#001233]" required>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Mobile Number (PH)</label>
                                        <div class="relative mt-1 rounded-md shadow-sm">
                                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none bg-gray-100 border border-r-0 border-gray-300 rounded-l-lg px-2">
                                                <span class="text-gray-500 font-bold sm:text-sm">
                                                    🇵🇭 +63
                                                </span>
                                            </div>
                                            <input type="text" name="passenger_phone" 
                                                   class="w-full pl-20 rounded-lg border-gray-300 focus:border-[#001233] focus:ring-[#001233]" 
                                                   placeholder="912 345 6789"
                                                   maxlength="10"
                                                   oninput="this.value = this.value.replace(/[^0-9]/g, ''); if(this.value.length > 10) this.value = this.value.slice(0, 10);"
                                                   required>
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Gender</label>
                                        <select name="passenger_gender" class="w-full rounded-lg border-gray-300 focus:border-[#001233] focus:ring-[#001233]">
                                            <option>Male</option>
                                            <option>Female</option>
                                            <option>Prefer not to say</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded-r-lg">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-blue-700">
                                                Ticket details will be sent to the email address provided above.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                    <a href="{{ route('booking.seats', $schedule->id) }}" class="px-6 py-3 border border-gray-300 text-gray-700 font-bold rounded-lg hover:bg-gray-50 transition">
                                        Back to Seats
                                    </a>
                                    
                                    <button type="submit" class="bg-[#001233] text-white font-bold py-3 px-8 rounded-lg shadow-md hover:bg-blue-900 transition">
                                        Proceed to Confirmation
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="w-full lg:w-1/3">
                        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-200 sticky top-6">
                            <h4 class="font-bold text-[#001233] mb-6 border-b border-gray-100 pb-4">Trip Summary</h4>
                            
                            <div class="space-y-4 mb-6">
                                <div>
                                    <span class="text-xs text-gray-400 font-bold uppercase">Route</span>
                                    <div class="flex items-center gap-2 text-sm font-bold text-gray-800 mt-1">
                                        <span>{{ $schedule->route->origin }}</span>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        <span>{{ $schedule->route->destination }}</span>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <span class="text-xs text-gray-400 font-bold uppercase">Date</span>
                                        <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('M d, Y') }}</p>
                                    </div>
                                    <div>
                                        <span class="text-xs text-gray-400 font-bold uppercase">Time</span>
                                        <p class="text-sm font-bold text-gray-800">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}</p>
                                    </div>
                                </div>

                                <div>
                                    <div class="flex justify-between items-center">
                                        <span class="text-xs text-gray-400 font-bold uppercase">Selected Seats</span>
                                        <a href="{{ route('booking.seats', $schedule->id) }}" class="text-xs text-blue-600 hover:underline font-bold flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                            Edit
                                        </a>
                                    </div>
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach($selectedSeats as $seat)
                                            <span class="bg-[#001233] text-white text-xs font-bold px-2 py-1 rounded">Seat {{ $seat }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                                <div class="flex justify-between text-sm text-gray-600 mb-2">
                                    <span>{{ count($selectedSeats) }} x Passenger</span>
                                    <span>₱ {{ number_format($schedule->route->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                                    <span class="font-bold text-gray-700">Total Amount</span>
                                    <span class="text-xl font-black text-[#001233]">₱ {{ number_format($totalPrice, 2) }}</span>
                                </div>
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
</x-app-layout>