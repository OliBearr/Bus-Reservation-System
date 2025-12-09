<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-[#001233] mb-8">
                My Bookings ({{ $reservations->count() }} total)
            </h1>

            <div class="space-y-6">
                @forelse ($reservations as $reservation)
                    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-6 transition hover:shadow-xl">
                        
                        <div class="flex justify-between items-start border-b border-dashed border-gray-200 pb-4 mb-4">
                            <div>
                                <h2 class="text-xl font-extrabold text-[#001233]">
                                    {{ $reservation->schedule->route->origin }} → {{ $reservation->schedule->route->destination }}
                                </h2>
                                <p class="text-sm text-gray-500 mt-1">
                                    Departure: {{ \Carbon\Carbon::parse($reservation->schedule->departure_time)->format('F d, Y \a\t h:i A') }}
                                </p>
                            </div>

                            <div class="text-right">
                                @php
                                    $isUpcoming = \Carbon\Carbon::parse($reservation->schedule->departure_time)->isFuture();
                                @endphp

                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                    {{ $isUpcoming ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-500' }}">
                                    {{ $isUpcoming ? 'Scheduled' : 'Completed' }}
                                </span>
                                <p class="text-2xl font-black text-green-600 mt-1">
                                    ₱ {{ number_format($reservation->schedule->route->price, 2) }}
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                            
                            <div>
                                <p class="font-bold text-gray-700">Booking ID</p>
                                <p class="text-gray-500 font-mono">#{{ $reservation->id }}</p>
                            </div>
                            
                            <div>
                                <p class="font-bold text-gray-700">Seat Number</p>
                                <span class="bg-[#001233] text-white px-2 py-0.5 rounded text-xs font-bold">
                                    {{ $reservation->seat_number }}
                                </span>
                            </div>
                            
                            <div>
                                <p class="font-bold text-gray-700">Bus Type</p>
                                <p class="text-gray-500">{{ $reservation->schedule->bus->type }}</p>
                            </div>
                            
                            <div>
                                <p class="font-bold text-gray-700">Bus Number</p>
                                <p class="text-gray-500">{{ $reservation->schedule->bus->bus_number }}</p>
                            </div>
                        </div>

                        <div class="pt-4 mt-4 border-t border-gray-100 flex justify-end">
                            <a href="{{ route('user.bookings.receipt', $reservation->id) }}" 
                               class="text-sm font-bold text-blue-600 hover:text-blue-800 transition flex items-center gap-1">
                                View Receipt & Details
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-12 text-center rounded-xl shadow-lg border border-gray-200">
                        <h3 class="text-xl font-medium text-gray-500 mb-2">You haven't booked any trips yet!</h3>
                        <p class="text-gray-400">Time to find your next destination.</p>
                        <a href="{{ url('/') }}" class="mt-6 inline-block bg-[#001233] text-white py-2.5 px-6 rounded-lg font-bold transition hover:bg-blue-900">
                            Start Searching
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>