<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <form action="{{ route('booking.confirm') }}" method="POST">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                {{-- Pass the seats string again --}}
                <input type="hidden" name="seats" value="{{ implode(',', $selectedSeats) }}">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    {{-- LEFT COLUMN: INPUT FORMS --}}
                    <div class="lg:col-span-2 space-y-8">
                        
                        {{-- 1. CONTACT DETAILS (The Booker) --}}
                        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                            <h2 class="text-xl font-bold text-[#001233] mb-4">Contact Details</h2>
                            <p class="text-sm text-gray-500 mb-6">Your tickets will be sent to this email address.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Mobile Number*</label>
                                    <input type="text" name="contact_phone" class="w-full rounded-lg border-gray-300 focus:ring-[#001233]" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Email Address*</label>
                                    <input type="email" name="contact_email" class="w-full rounded-lg border-gray-300 focus:ring-[#001233]" required>
                                </div>
                            </div>
                        </div>

                        {{-- 2. PASSENGER DETAILS LOOP --}}
                        @foreach ($selectedSeats as $index => $seat)
                            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 relative overflow-hidden">
                                {{-- Visual Sidebar --}}
                                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-[#001233]"></div>
                                
                                <div class="flex justify-between items-center mb-6">
                                    <h3 class="text-lg font-bold text-[#001233]">Passenger {{ $index + 1 }}</h3>
                                    <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-xs font-bold">
                                        Seat {{ $seat }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">First Name</label>
                                        {{-- Array Name: passengers[0][first_name] --}}
                                        <input type="text" name="passengers[{{ $index }}][first_name]" class="w-full rounded-lg border-gray-300 focus:ring-[#001233]" required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-2">Surname</label>
                                        <input type="text" name="passengers[{{ $index }}][surname]" class="w-full rounded-lg border-gray-300 focus:ring-[#001233]" required>
                                    </div>
                                </div>

                                {{-- Discount Section --}}
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <label class="block text-sm font-bold text-gray-700 mb-2">Discount ID (Optional)</label>
                                    <input type="text" name="passengers[{{ $index }}][discount_id]" class="w-full rounded-lg border-gray-300 focus:ring-[#001233]" placeholder="Senior Citizen / PWD ID Number">
                                    <p class="text-xs text-gray-500 mt-1 italic">Only applicable to Senior/PWD/Student Filipino citizens</p>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    {{-- RIGHT COLUMN: SUMMARY --}}
                    <div class="lg:col-span-1">
                        <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 sticky top-4">
                            <h3 class="text-xl font-bold text-[#001233] mb-6 border-b pb-4">Trip Summary</h3>
                            
                            <div class="mb-6">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-500 font-bold text-xs uppercase tracking-wider">Route</span>
                                </div>
                                <div class="flex items-center gap-2 text-lg font-bold">
                                    <span>{{ $schedule->route->origin }}</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                    <span>{{ $schedule->route->destination }}</span>
                                </div>
                            </div>

                            <div class="mb-6">
                                <span class="text-gray-500 font-bold text-xs uppercase tracking-wider block mb-1">Departure</span>
                                <div class="font-bold text-gray-800">
                                    {{ \Carbon\Carbon::parse($schedule->departure_time)->format('D, M d Y') }}
                                    <span class="text-gray-400 mx-1">|</span>
                                    {{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}
                                </div>
                            </div>

                            <div class="mb-6">

                            <div class="flex items-center justify-between mb-1">
                                <span class="text-gray-500 font-bold text-xs uppercase tracking-wider">
                                    Selected Seats
                                </span>

                                <a href="{{ route('booking.seats', $schedule->id) }}" 
                                class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1 transition">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    Edit
                                </a>
                            </div>

                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedSeats as $seat)
                                    <span class="bg-[#001233] text-white px-3 py-1 rounded text-sm font-bold">
                                        {{ $seat }}
                                    </span>
                                @endforeach
                            </div>

                        </div>

                           <div class="border-t pt-4 mt-4">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-gray-600">Total Price</span>
                                    <span class="text-2xl font-black text-[#001233]">₱ {{ number_format($totalPrice, 2) }}</span>
                                </div>

                                {{-- BUTTONS ROW --}}
                                <div class="flex gap-3 mt-4">
                                    {{-- Cancel Button (Links back to Dashboard) --}}
                                    <a href="{{ route('home') }}" class="w-1/2 bg-red-700 text-white py-3 rounded-lg font-bold hover:bg-red-900 transition text-center shadow-lg flex items-center justify-center">
                                        Cancel Booking
                                    </a>

                                    {{-- Confirm Button --}}
                                    <button type="submit" class="w-1/2 bg-[#001233] text-white py-3 rounded-lg font-bold hover:bg-blue-900 transition shadow-lg">
                                        Confirm
                                    </button>
                                </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
