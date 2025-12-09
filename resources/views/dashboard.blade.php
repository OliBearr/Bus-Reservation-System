<x-app-layout>
    
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
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z"></path></svg>
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

    <div class="relative w-full h-[350px] flex-shrink-0">
        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2069&auto=format&fit=crop" 
             class="w-full h-full object-cover">
        
        <div class="absolute inset-0 bg-[#001233]/50"></div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-3xl md:text-5xl font-extrabold text-white drop-shadow-lg mb-6">
                <span class="text-yellow-400">Welcome, {{ Auth::user()->name }}!</span><br>Where to next?
            </h1>

            <form id="searchForm" action="{{ route('dashboard') }}" method="GET" class="bg-white p-2 rounded-lg shadow-xl flex flex-col md:flex-row items-center gap-2 w-full max-w-5xl">
                
                <input type="hidden" name="hide_full" id="input_hide_full" value="{{ request('hide_full') }}">
                <input type="hidden" name="bus_type" id="input_bus_type" value="{{ request('bus_type') }}">

                <div class="flex items-center bg-gray-50 rounded px-4 py-3 flex-1 w-full border border-gray-200">
                    <div class="mr-3 text-[#001233]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                    <select name="origin" class="w-full bg-transparent border-none p-0 text-[#001233] font-bold focus:ring-0 cursor-pointer outline-none">
                        <option value="">Select Origin</option>
                        @foreach($origins as $origin)
                            <option value="{{ $origin }}" {{ request('origin') == $origin ? 'selected' : '' }}>{{ $origin }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center bg-gray-50 rounded px-4 py-3 flex-1 w-full border border-gray-200">
                    <div class="mr-3 text-[#001233]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                    <select name="destination" class="w-full bg-transparent border-none p-0 text-[#001233] font-bold focus:ring-0 cursor-pointer outline-none">
                        <option value="">Select Destination</option>
                        @foreach($destinations as $destination)
                            <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>{{ $destination }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center bg-gray-50 rounded px-4 py-3 flex-1 w-full border border-gray-200">
                    <div class="mr-3 text-[#001233]"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg></div>
                    <input type="date" name="date" id="input_date" class="w-full bg-transparent border-none p-0 text-[#001233] font-bold focus:ring-0 outline-none" value="{{ $searchDate }}">
                </div>

                <button type="submit" class="bg-[#001233] hover:bg-blue-900 text-white font-bold py-4 px-8 rounded h-full w-full md:w-auto shadow-lg transition tracking-wide">Find Available</button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 flex-grow w-full">
        
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <button onclick="toggleFilterDrawer()" class="flex items-center gap-2 text-[#001233] font-bold hover:text-blue-700 mb-4 md:mb-0 transition focus:outline-none">
                    <svg id="filter-icon" class="w-6 h-6 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span id="filter-text">Add Filter</span>
                </button>

                <div class="flex items-center gap-3">
                    <label for="toggle" class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" id="toggle" class="sr-only peer"
                               {{ request('hide_full') ? 'checked' : '' }}
                               onchange="toggleFullBooked(this)">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-gray-300 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#001233]"></div>
                    </label>
                    <label for="toggle" class="text-gray-500 font-medium cursor-pointer">Hide Fully-Booked Trips</label>
                </div>
            </div>

            <div id="filter-drawer" class="{{ request('bus_type') ? '' : 'hidden' }} mt-4 bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Filter by Bus Type</p>
                <div class="flex gap-3 flex-wrap">
                    <button onclick="setBusType('')" class="px-6 py-2 rounded-full text-sm font-bold border transition {{ !request('bus_type') ? 'bg-[#001233] text-white border-[#001233]' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-400' }}">All Types</button>
                    @foreach($busTypes as $type)
                        <button onclick="setBusType('{{ $type }}')" class="px-6 py-2 rounded-full text-sm font-bold border transition {{ request('bus_type') == $type ? 'bg-[#001233] text-white border-[#001233]' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-400' }}">{{ $type }}</button>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between gap-4 mb-10">
            <button onclick="changeDate(-1)" class="bg-white p-3 rounded-xl shadow-sm hover:shadow-md text-[#001233] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <div class="flex gap-2 overflow-x-auto no-scrollbar w-full">
                @foreach($dates as $date)
                    @php $isActive = $date->format('Y-m-d') === $searchDate; @endphp
                    <div onclick="setDate('{{ $date->format('Y-m-d') }}')" 
                         class="flex-1 min-w-[140px] text-center py-4 bg-white border {{ $isActive ? 'border-[#001233] border-b-4' : 'border-gray-200' }} cursor-pointer hover:bg-gray-50 transition rounded-lg shadow-sm">
                        <p class="text-sm font-bold {{ $isActive ? 'text-[#001233]' : 'text-gray-500' }}">{{ $date->format('D, d M') }}</p>
                    </div>
                @endforeach
            </div>

            <button onclick="changeDate(1)" class="bg-white p-3 rounded-xl shadow-sm hover:shadow-md text-[#001233] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>

        <div class="space-y-4">
            @forelse($schedules as $schedule)
                @php
                    $seatsTaken = $schedule->reservations->pluck('seat_number')->toArray();
                    $capacity = $schedule->bus->capacity;
                    $seatsLeft = $capacity - count($seatsTaken);
                    $isFull = $seatsLeft <= 0;
                @endphp

            <div x-data="{ 
                    expanded: false, 
                    selected: [], 
                    price: {{ $schedule->route->price }},
                    toggleSeat(seat) {
                        if (this.selected.includes(seat)) {
                            this.selected = this.selected.filter(s => s !== seat);
                        } else {
                            this.selected.push(seat);
                        }
                    },
                    get total() {
                        return (this.selected.length * this.price).toLocaleString('en-US', {minimumFractionDigits: 2});
                    }
                 }" 
                 class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all">
                
                <div class="p-6">
                    <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-100 pb-6 mb-4">
                        <div class="flex items-center gap-12 w-full md:w-auto">
                            <div class="text-center md:text-left">
                                <h3 class="text-3xl font-black text-[#001233]">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}</h3>
                            </div>
                            <div class="flex items-center gap-8 flex-1">
                                <span class="text-xl font-bold text-[#001233]">{{ $schedule->route->origin }}</span>
                                <div class="flex-1"><svg class="w-6 h-6 text-[#001233] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg></div>
                                <span class="text-xl font-bold text-[#001233]">{{ $schedule->route->destination }}</span>
                            </div>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <span class="text-2xl font-bold text-[#001233]">PHP {{ number_format($schedule->route->price, 2) }}</span>
                        </div>
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                        <div class="flex gap-12 text-sm text-gray-500 w-full md:w-auto">
                            <div><p class="font-bold text-[#001233]">Bus Type</p><p>{{ $schedule->bus->type }}</p></div>
                            <div><p class="font-bold text-[#001233]">Trip Type</p><p>One Way</p></div>
                            <div><p class="font-bold text-[#001233]">Code</p><p>BC{{ $schedule->id }}</p></div>
                        </div>
                        
                        <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                            @if($isFull)
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">FULLY BOOKED</span>
                            @else
                                <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white text-green-700 border border-gray-300">
                                    <span class="w-2.5 h-2.5 mr-2 bg-green-500 rounded-full"></span>{{ $seatsLeft }} left
                                </span>
                                <button @click="expanded = !expanded" 
                                        :class="expanded ? 'bg-gray-200 text-[#001233]' : 'bg-[#001233] text-white hover:bg-blue-900'"
                                        class="font-bold py-2 px-6 rounded-full shadow transition flex items-center gap-2">
                                    <span x-text="expanded ? 'Hide Seats' : 'Show Seats'"></span>
                                    <svg x-show="!expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    <svg x-show="expanded" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div x-show="expanded" x-collapse 
                     class="bg-white border-t border-gray-100 px-8 py-8">
                    
                    <div class="flex flex-col lg:flex-row gap-8">
                        
                        <div class="w-full lg:w-2/3 border-r border-gray-100 pr-8">
                            <h4 class="font-bold text-[#001233] mb-6">Select your seat(s) here.</h4>
                            
                            <div class="bg-[#F3F4F6] p-8 rounded-2xl border border-gray-200 max-w-sm">
                                <div class="grid grid-cols-5 gap-3">
                                    @for($i = 1; $i <= $schedule->bus->capacity; $i++)
                                        @php $isTaken = in_array($i, $seatsTaken); @endphp
                                        
                                        @if($i % 4 == 3 && $i > 1) <div></div> @endif

                                        <button 
                                            @if(!$isTaken) @click="toggleSeat({{ $i }})" @endif
                                            :class="selected.includes({{ $i }}) 
                                                ? 'bg-[#10B981] text-white border-[#10B981] shadow-md scale-105' 
                                                : '{{ $isTaken ? 'bg-gray-400 text-gray-200 cursor-not-allowed border-transparent' : 'bg-white text-gray-600 border-gray-200 hover:border-[#001233]' }}'"
                                            class="h-10 w-10 rounded-lg font-bold text-xs transition border flex items-center justify-center transform duration-150">
                                            {{ $isTaken ? 'X' : $i }}
                                        </button>
                                    @endfor
                                </div>
                            </div>

                            <div class="flex gap-6 mt-6 text-sm text-gray-500 font-medium items-center ml-2">
                                <span class="text-gray-400 font-bold uppercase tracking-wide mr-2 text-xs">Legend</span>
                                <div class="flex items-center gap-2"><div class="w-4 h-4 rounded bg-white border-2 border-gray-200"></div> Available</div>
                                <div class="flex items-center gap-2"><div class="w-4 h-4 rounded bg-gray-400"></div> Reserved</div>
                                <div class="flex items-center gap-2"><div class="w-4 h-4 rounded bg-[#10B981]"></div> Selected</div>
                            </div>
                        </div>

                        <div class="w-full lg:w-1/3 pl-4 flex flex-col justify-between py-2">
                            
                            <div class="space-y-6 mb-6">
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-500 text-sm font-medium">Pick-up Time</span>
                                    <span class="font-black text-[#001233] text-lg">
                                        {{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}
                                    </span>
                                </div>

                                <div class="space-y-4">
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
                            </div>
                            
                            <div class="mt-auto">
                                <div class="space-y-2 mb-6">
                                    <div class="flex justify-between text-sm text-gray-500">
                                        <span>Seat(s) Selected</span>
                                        <span class="font-bold text-[#001233]" x-text="selected.length > 0 ? selected.join(', ') : '-'"></span>
                                    </div>
                                    <div class="flex justify-between text-sm text-gray-500">
                                        <span>Fare Per Seat</span>
                                        <span class="font-bold text-[#001233]">PHP {{ number_format($schedule->route->price, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-end border-t border-gray-200 pt-4">
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Total Fare</span>
                                        <span class="font-black text-2xl text-[#001233]">PHP <span x-text="total"></span></span>
                                    </div>
                                </div>

                                <form action="{{ route('booking.details') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                    
                                    <input type="hidden" name="seats" :value="selected.join(',')">

                                    <button :disabled="selected.length === 0"
                                            :class="selected.length > 0 ? 'bg-[#001233] hover:bg-blue-900 text-white shadow-lg' : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                                            class="w-full py-3 font-bold rounded-lg transition uppercase text-xs tracking-widest">
                                        Reserve Seat/s
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <img src="{{ asset('images/no-trips.png') }}" alt="No Available Trips" class="h-24 w-auto mb-4 opacity-40 grayscale">
                    <h3 class="text-xl font-medium text-gray-500">No Available Trips</h3>
                    <p class="text-gray-400 mt-2 text-sm">We couldn't find any buses for this date.<br>Try changing your filters.</p>
                    <a href="{{ route('dashboard') }}" class="mt-6 px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded-full hover:bg-gray-300 transition text-sm">Clear All Filters</a>
                </div>
            @endforelse
        </div>
    </div>

    <footer class="bg-[#001233] text-white py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm">© 2025 BusPH. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function setDate(date) { document.getElementById('input_date').value = date; document.getElementById('searchForm').submit(); }
        function toggleFullBooked(checkbox) { document.getElementById('input_hide_full').value = checkbox.checked ? '1' : ''; document.getElementById('searchForm').submit(); }
        function setBusType(type) { document.getElementById('input_bus_type').value = type; document.getElementById('searchForm').submit(); }
        function toggleFilterDrawer() {
            const drawer = document.getElementById('filter-drawer'); const icon = document.getElementById('filter-icon'); const text = document.getElementById('filter-text');
            if (drawer.classList.contains('hidden')) { drawer.classList.remove('hidden'); icon.style.transform = 'rotate(45deg)'; text.innerText = "Close Filters"; } 
            else { drawer.classList.add('hidden'); icon.style.transform = 'rotate(0deg)'; text.innerText = "Add Filter"; }
        }
        function changeDate(days) {
            const current = new Date(document.getElementById('input_date').value); current.setDate(current.getDate() + days);
            setDate(current.toISOString().split('T')[0]);
        }
    </script>
</x-app-layout>