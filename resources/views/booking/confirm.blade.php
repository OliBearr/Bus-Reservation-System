<x-app-layout>
    <div class="flex flex-col min-h-screen">
        
        <div class="bg-white border-b border-gray-200 shadow-sm relative z-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
                <div class="flex items-center justify-center space-x-6 text-sm font-medium">
                    
                    <a href="{{ route('booking.seats', $schedule->id) }}" class="flex items-center text-green-600 hover:text-green-800 transition cursor-pointer group">
                        <div class="p-1 border border-green-600 rounded-full mr-2 group-hover:bg-green-600 group-hover:text-white transition">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Trip Details</span>
                    </a>
                    
                    <span class="text-gray-300">/</span>
                    
                    <div class="flex items-center text-green-600">
                        <div class="p-1 border border-green-600 rounded-full mr-2">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <span>Reservation Details</span>
                    </div>

                    <span class="text-gray-300">/</span>

                    <div class="flex items-center text-[#001233]">
                        <div class="p-1 bg-[#001233] rounded-full text-white mr-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="font-bold border-b-2 border-[#001233] pb-0.5">Confirm Booking</span>
                    </div>

                </div>
            </div>
        </div>

        <div class="py-12 flex-grow bg-gray-50">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <h2 class="text-3xl font-bold text-[#001233] mb-8 text-center">Review Your Booking</h2>

                <div class="flex flex-col lg:flex-row gap-8">
                    
                    <div class="w-full lg:w-2/3 space-y-6">
                        
                        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                                <h3 class="text-lg font-bold text-[#001233] flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    Passenger Details
                                </h3>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-6 gap-x-12">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Full Name</p>
                                    <p class="font-bold text-gray-800 text-lg">{{ $passenger['passenger_name'] }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Email Address</p>
                                    <p class="font-bold text-gray-800 text-lg">{{ $passenger['passenger_email'] }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Mobile Number</p>
                                    <p class="font-bold text-gray-800 text-lg">+63 {{ $passenger['passenger_phone'] }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-1">Gender</p>
                                    <p class="font-bold text-gray-800 text-lg">{{ $passenger['passenger_gender'] }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-200">
                            <div class="flex justify-between items-center border-b border-gray-100 pb-4 mb-6">
                                <h3 class="text-lg font-bold text-[#001233] flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Trip Details
                                </h3>
                                
                                <a href="{{ route('booking.seats', $schedule->id) }}" class="text-xs font-bold text-blue-600 hover:text-blue-800 flex items-center gap-1 transition uppercase tracking-wide">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    Edit Seats
                                </a>
                            </div>

                            <div class="flex flex-col md:flex-row items-center gap-8 mb-6">
                                <div class="text-center md:text-left">
                                    <p class="text-4xl font-black text-[#001233]">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}</p>
                                    <p class="text-sm font-bold text-gray-500 uppercase tracking-wider">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('M d, Y') }}</p>
                                </div>
                                
                                <div class="hidden md:block h-12 w-px bg-gray-300"></div>
                                
                                <div class="flex-1 w-full text-center md:text-left">
                                    <div class="flex items-center justify-center md:justify-start gap-3 text-xl font-bold text-gray-800">
                                        <span>{{ $schedule->route->origin }}</span>
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        <span>{{ $schedule->route->destination }}</span>
                                    </div>
                                    <div class="flex justify-center md:justify-start gap-4 mt-2 text-sm text-gray-500">
                                        <p>Type: <span class="font-bold text-[#001233]">{{ $schedule->bus->type }}</span></p>
                                        <p>Code: <span class="font-bold text-[#001233]">BC{{ $schedule->id }}</span></p>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-3">Selected Seats</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($selectedSeats as $seat)
                                        <span class="bg-[#001233] text-white text-sm font-bold px-4 py-2 rounded-lg shadow-sm">Seat {{ $seat }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="w-full lg:w-1/3">
                        <div class="bg-white p-8 rounded-xl shadow-lg border border-gray-200 sticky top-6">
                            <h4 class="text-lg font-bold text-[#001233] mb-6 border-b border-gray-100 pb-4">Payment Summary</h4>
                            
                            <div class="space-y-4 mb-8 text-sm text-gray-600">
                                <div class="flex justify-between">
                                    <span>Fare x {{ count($selectedSeats) }}</span>
                                    <span class="font-bold text-gray-800">₱ {{ number_format($totalPrice, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span>Booking Fee</span>
                                    <span class="font-bold text-gray-800">₱ 0.00</span>
                                </div>
                                <div class="flex justify-between text-green-600 font-bold">
                                    <span>Total Discount</span>
                                    <span>- ₱ 0.00</span>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl flex justify-between items-center mb-8 border border-gray-200">
                                <div>
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wide">Total to Pay</p>
                                    <p class="text-3xl font-black text-[#001233]">₱ {{ number_format($totalPrice, 2) }}</p>
                                </div>
                            </div>

                            <form action="{{ route('booking.payment') }}" method="POST"> 
                                @csrf
                                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                <input type="hidden" name="seats" value="{{ implode(',', $selectedSeats) }}">
                                <input type="hidden" name="passenger_name" value="{{ $passenger['passenger_name'] }}">
                                <input type="hidden" name="passenger_email" value="{{ $passenger['passenger_email'] }}">
                                <input type="hidden" name="passenger_phone" value="{{ $passenger['passenger_phone'] }}">
                                <input type="hidden" name="passenger_gender" value="{{ $passenger['passenger_gender'] }}">

                                <button type="submit" class="w-full py-4 bg-[#10B981] hover:bg-green-600 text-white font-bold rounded-xl shadow-lg transition uppercase tracking-widest flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                    Pay & Book
                                </button>
                            </form>
                            
                            <div class="mt-6 text-center">
                                <a href="{{ route('dashboard', [
                                    'origin' => $schedule->route->origin, 
                                    'destination' => $schedule->route->destination, 
                                    'date' => \Carbon\Carbon::parse($schedule->departure_time)->format('Y-m-d')
                                ]) }}" class="text-xs text-red-400 hover:text-red-600 font-bold uppercase tracking-wide transition">
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
</x-app-layout>