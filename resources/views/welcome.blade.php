<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BusPH') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Hide scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

        /* TOGGLE SWITCH ANIMATION */
        .toggle-checkbox {
            /* Start at original position */
            transform: translateX(0);
            transition: transform 0.3s ease-in-out, background-color 0.3s, border-color 0.3s;
        }
        
        .toggle-checkbox:checked {
            /* Move 100% of its own width to the right */
            transform: translateX(100%); 
            border-color: #0059ff;
        }
        
        .toggle-checkbox:checked + .toggle-label {
            background-color: #0059ff;
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4F6] flex flex-col min-h-screen">

    <nav class="bg-[#001233] text-white py-4 shadow-md z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="BusPH" class="h-10 w-auto"> 
                <span class="font-bold text-xl">BusPH</span>
            </div>

            <div class="flex items-center gap-8">
                {{-- Consolidated About Us Link --}}
                <a href="{{ route('about') }}" class="text-sm font-medium hover:text-gray-300 transition">ABOUT US</a>
                
                @if (Route::has('login'))
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="bg-white text-[#001233] px-6 py-2 rounded font-bold text-sm hover:bg-gray-100 transition">ADMIN PANEL</a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="bg-white text-[#001233] px-6 py-2 rounded font-bold text-sm hover:bg-gray-100 transition">DASHBOARD</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="bg-white text-[#001233] px-6 py-2 rounded font-bold text-sm hover:bg-gray-100 transition">LOGIN NOW</a>
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <div class="relative w-full h-[450px] flex-shrink-0">
        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2069&auto=format&fit=crop" 
             class="w-full h-full object-cover">
        
        <div class="absolute inset-0 bg-[#001233]/40"></div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white drop-shadow-lg mb-8">
                <span class="text-yellow-400">Hassle-Free.</span> Book Anytime. Anywhere. with BusPH
            </h1>

            <form id="searchForm" action="{{ route('home') }}" method="GET" class="bg-white p-2 rounded-lg shadow-2xl flex flex-col md:flex-row items-center gap-2 w-full max-w-5xl">
                
                <input type="hidden" name="hide_full" id="input_hide_full" value="{{ request('hide_full') }}">
                <input type="hidden" name="bus_type" id="input_bus_type" value="{{ request('bus_type') }}">

                <div class="flex items-center bg-gray-50 rounded px-4 py-3 flex-1 w-full border border-gray-200">
                    <div class="mr-3 text-[#001233]">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="text-left w-full">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">From Terminal</label>
                        <select name="origin" class="w-full bg-transparent border-none p-0 text-[#001233] font-bold focus:ring-0 cursor-pointer outline-none">
                            <option value="">Select Origin</option>
                            @foreach($origins as $origin)
                                <option value="{{ $origin }}" {{ request('origin') == $origin ? 'selected' : '' }}>{{ $origin }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="hidden md:flex bg-gray-100 rounded-full p-2 text-[#001233]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path></svg>
                </div>

                <div class="flex items-center bg-gray-50 rounded px-4 py-3 flex-1 w-full border border-gray-200">
                    <div class="mr-3 text-[#001233]">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="text-left w-full">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">To Terminal</label>
                        <select name="destination" class="w-full bg-transparent border-none p-0 text-[#001233] font-bold focus:ring-0 cursor-pointer outline-none">
                            <option value="">Select Destination</option>
                            @foreach($destinations as $destination)
                                <option value="{{ $destination }}" {{ request('destination') == $destination ? 'selected' : '' }}>{{ $destination }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center bg-gray-50 rounded px-4 py-3 flex-1 w-full border border-gray-200">
                    <div class="mr-3 text-[#001233]">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="text-left w-full">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">Trip Date</label>
                        <input type="date" name="date" id="input_date" class="w-full bg-transparent border-none p-0 text-[#001233] font-bold focus:ring-0 outline-none" value="{{ $searchDate }}">
                    </div>
                </div>

                <button type="submit" class="bg-[#001233] hover:bg-blue-900 text-white font-bold py-4 px-8 rounded h-full w-full md:w-auto shadow-lg transition tracking-wide">
                    Find Available
                </button>
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
                    <div class="relative inline-block w-12 h-6 align-middle select-none transition duration-200 ease-in">
                        
                        <label for="toggle" 
                               class="toggle-label block overflow-hidden h-6 rounded-full bg-gray-300 cursor-pointer"></label>
                        
                        <input type="checkbox" id="toggle" 
                               class="toggle-checkbox absolute block w-6 h-6 rounded-full bg-white border-4 border-gray-300 appearance-none cursor-pointer top-0 left-0"
                               {{ request('hide_full') ? 'checked' : '' }}
                               onchange="toggleFullBooked(this)"/>
                    </div>
                    <label for="toggle" class="text-gray-500 font-medium cursor-pointer">Hide Fully-Booked Trips</label>
                </div>
            </div>

            <div id="filter-drawer" class="{{ request('bus_type') ? '' : 'hidden' }} mt-4 bg-white p-6 rounded-lg shadow-sm border border-gray-200 animate-fade-in-down">
                <p class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-3">Filter by Bus Type</p>
                <div class="flex gap-3 flex-wrap">
                    <button onclick="setBusType('')" 
                            class="px-6 py-2 rounded-full text-sm font-bold border transition {{ !request('bus_type') ? 'bg-[#001233] text-white border-[#001233]' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-400' }}">
                        All Types
                    </button>
                    @if(isset($busTypes))
                        @foreach($busTypes as $type)
                            <button onclick="setBusType('{{ $type }}')" 
                                    class="px-6 py-2 rounded-full text-sm font-bold border transition {{ request('bus_type') == $type ? 'bg-[#001233] text-white border-[#001233]' : 'bg-white text-gray-600 border-gray-200 hover:border-gray-400' }}">
                                {{ $type }}
                            </button>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between gap-4 mb-10">
            <button onclick="changeDate(-1)" class="bg-white p-3 rounded-xl shadow-sm hover:shadow-md text-[#001233] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <div class="flex gap-2 overflow-x-auto no-scrollbar w-full">
                @if(isset($dates))
                    @foreach($dates as $date)
                        @php 
                            $isActive = $date->format('Y-m-d') === $searchDate; 
                        @endphp
                        <div onclick="setDate('{{ $date->format('Y-m-d') }}')" 
                             class="flex-1 min-w-[140px] text-center py-4 bg-white border {{ $isActive ? 'border-[#001233] border-b-4' : 'border-gray-200' }} cursor-pointer hover:bg-gray-50 transition rounded-lg shadow-sm">
                            <p class="text-sm font-bold {{ $isActive ? 'text-[#001233]' : 'text-gray-500' }}">
                                {{ $date->format('D, d M') }}
                            </p>
                        </div>
                    @endforeach
                @endif
            </div>

            <button onclick="changeDate(1)" class="bg-white p-3 rounded-xl shadow-sm hover:shadow-md text-[#001233] transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </button>
        </div>

        <div class="space-y-4">
            @forelse($schedules as $schedule)
                @php
                    $seatsTaken = $schedule->reservations_count ?? 0;
                    $capacity = $schedule->bus->capacity ?? 0;
                    $seatsLeft = $capacity - $seatsTaken;
                    $isFull = $seatsLeft <= 0;
                @endphp

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-100 pb-6 mb-4">
                    <div class="flex items-center gap-12 w-full md:w-auto">
                        <div class="text-center md:text-left">
                            <h3 class="text-3xl font-black text-[#001233]">
                                {{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}
                            </h3>
                        </div>
                        <div class="flex items-center gap-8 flex-1">
                            <span class="text-xl font-bold text-[#001233]">{{ $schedule->route->origin }}</span>
                            <div class="flex-1">
                                <svg class="w-6 h-6 text-[#001233] mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                            </div>
                            <span class="text-xl font-bold text-[#001233]">{{ $schedule->route->destination }}</span>
                        </div>
                    </div>
                    <div class="mt-4 md:mt-0">
                        <span class="text-2xl font-bold text-[#001233]">PHP {{ number_format($schedule->route->price, 2) }}</span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex gap-12 text-sm text-gray-500 w-full md:w-auto">
                        <div>
                            <p class="font-bold text-[#001233]">Bus Type</p>
                            <p>{{ $schedule->bus->type }}</p>
                        </div>
                        <div>
                            <p class="font-bold text-[#001233]">Trip Type</p>
                            <p>One Way</p>
                        </div>
                        <div>
                            <p class="font-bold text-[#001233]">Code</p>
                            <p>BC{{ $schedule->id }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                        @if($isFull)
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-red-100 text-red-800 border border-red-200">
                                FULLY BOOKED
                            </span>
                            <button disabled class="bg-gray-300 text-white font-bold py-2 px-6 rounded-full cursor-not-allowed">
                                Select Seat
                            </button>
                        @else
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-xs font-bold bg-white text-green-700 border border-gray-300">
                                <span class="w-2.5 h-2.5 mr-2 bg-green-500 rounded-full"></span>
                                {{ $seatsLeft }} left
                            </span>
                            <button class="bg-[#001233] hover:bg-blue-900 text-white font-bold py-2 px-6 rounded-full shadow transition flex items-center gap-2">
                                <a href="{{ route('booking.seats', $schedule->id) }}" class="bg-[#001233] hover:bg-blue-900 text-white font-bold py-2 px-6 rounded-full shadow transition flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    Show Seats
                                </a>
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            
            @empty
                <div class="flex flex-col items-center justify-center py-20 text-center">
                    <img src="{{ asset('images/no-trips.png') }}" alt="No Available Trips" class="h-24 w-auto mb-4 opacity-40 grayscale">
                    <h3 class="text-xl font-medium text-gray-500">No Available Trips</h3>
                    <p class="text-gray-400 mt-2 text-sm">We couldn't find any buses for this date.<br>Try changing your filters.</p>
                    <a href="{{ route('home') }}" class="mt-6 px-6 py-2 bg-gray-200 text-gray-700 font-bold rounded-full hover:bg-gray-300 transition text-sm">
                        Clear All Filters
                    </a>
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
        function setDate(date) {
            document.getElementById('input_date').value = date;
            document.getElementById('searchForm').submit();
        }
        function toggleFullBooked(checkbox) {
            const val = checkbox.checked ? '1' : '';
            document.getElementById('input_hide_full').value = val;
            document.getElementById('searchForm').submit();
        }
        function setBusType(type) {
            document.getElementById('input_bus_type').value = type;
            document.getElementById('searchForm').submit();
        }
        function toggleFilterDrawer() {
            const drawer = document.getElementById('filter-drawer');
            const icon = document.getElementById('filter-icon');
            const text = document.getElementById('filter-text');
            if (drawer.classList.contains('hidden')) {
                drawer.classList.remove('hidden');
                icon.style.transform = 'rotate(45deg)';
                text.innerText = "Close Filters";
            } else {
                drawer.classList.add('hidden');
                icon.style.transform = 'rotate(0deg)';
                text.innerText = "Add Filter";
            }
        }
        function changeDate(days) {
            const currentInput = document.getElementById('input_date').value;
            const current = currentInput ? new Date(currentInput) : new Date();
            current.setDate(current.getDate() + days);
            const year = current.getFullYear();
            const month = String(current.getMonth() + 1).padStart(2, '0');
            const day = String(current.getDate()).padStart(2, '0');
            setDate(`${year}-${month}-${day}`);
        }
    </script>

</body>
</html>