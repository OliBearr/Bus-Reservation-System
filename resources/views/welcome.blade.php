<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'BusPH') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F3F4F6]">

    <nav class="bg-[#001233] text-white py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <img src="{{ asset('images/logo.png') }}" alt="BusPH" class="h-10 w-auto"> 
            </div>
            <div class="flex items-center gap-8">
                <a href="#" class="text-sm font-medium hover:text-gray-300">ABOUT US</a>
                <a href="#" class="text-sm font-medium hover:text-gray-300">MANAGE</a>
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

    <div class="relative w-full h-[500px]">
        <img src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2069&auto=format&fit=crop" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-[#001233]/40"></div>

        <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white drop-shadow-lg mb-8">
                <span class="text-yellow-400">Hassle-Free.</span> Book Anytime. Anywhere. with BusPH
            </h1>

            <form action="{{ route('home') }}" method="GET" class="bg-white p-2 rounded-lg shadow-2xl flex flex-col md:flex-row items-center gap-2 w-full max-w-5xl">
                
                <div class="flex items-center bg-gray-50 rounded px-4 py-3 flex-1 w-full border border-gray-200">
                    <div class="mr-3 text-[#001233]">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="text-left w-full">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">From Terminal</label>
                        <select name="origin" class="w-full bg-transparent border-none p-0 text-[#001233] font-bold focus:ring-0 cursor-pointer">
                            <option value="">Select Origin</option>
                            @foreach($origins as $origin)
                                <option value="{{ $origin }}" {{ request('origin') == $origin ? 'selected' : '' }}>{{ $origin }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center bg-gray-50 rounded px-4 py-3 flex-1 w-full border border-gray-200">
                    <div class="mr-3 text-[#001233]">
                         <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    </div>
                    <div class="text-left w-full">
                        <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide">To Terminal</label>
                        <select name="destination" class="w-full bg-transparent border-none p-0 text-[#001233] font-bold focus:ring-0 cursor-pointer">
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
                        <input type="date" name="date" class="w-full bg-transparent border-none p-0 text-[#001233] font-bold focus:ring-0" value="{{ $searchDate }}">
                    </div>
                </div>

                <button type="submit" class="bg-[#001233] hover:bg-blue-900 text-white font-bold py-4 px-8 rounded h-full w-full md:w-auto shadow-lg transition">
                    Find Available
                </button>
            </form>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        @if(request()->has('origin'))
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-[#001233]">
                Trips from {{ request('origin') }} to {{ request('destination') }}
            </h2>
            <p class="text-gray-500">{{ \Carbon\Carbon::parse($searchDate)->format('l, F d, Y') }}</p>
        </div>
        @endif

        <div class="space-y-4">
            
            @forelse($schedules as $schedule)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
                <div class="flex flex-col md:flex-row justify-between items-center border-b border-gray-100 pb-6 mb-4">
                    <div class="flex items-center gap-12 w-full md:w-auto">
                        <div class="text-center md:text-left">
                            <h3 class="text-2xl font-black text-[#001233]">
                                {{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}
                            </h3>
                            <p class="text-sm text-gray-400">Departure</p>
                        </div>
                        <div class="flex items-center gap-8 flex-1">
                            <span class="text-lg font-bold text-[#001233]">{{ $schedule->route->origin }}</span>
                            <div class="flex-1 border-t-2 border-dashed border-gray-300 relative top-1 min-w-[50px]">
                                <svg class="w-4 h-4 absolute -right-0 -top-2.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </div>
                            <span class="text-lg font-bold text-[#001233]">{{ $schedule->route->destination }}</span>
                        </div>
                    </div>
                    
                    <div class="mt-4 md:mt-0">
                        <span class="text-2xl font-bold text-[#001233]">PHP {{ number_format($schedule->route->price, 2) }}</span>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <div class="flex gap-12 text-sm text-gray-500 w-full md:w-auto">
                        <div>
                            <p class="font-bold text-[#001233]">Bus No.</p>
                            <p>{{ $schedule->bus->bus_number }}</p>
                        </div>
                        <div>
                            <p class="font-bold text-[#001233]">Bus Type</p>
                            <p>{{ $schedule->bus->type }}</p>
                        </div>
                        <div>
                            <p class="font-bold text-[#001233]">Trip ID</p>
                            <p>#{{ $schedule->id }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 w-full md:w-auto justify-end">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <span class="w-2 h-2 mr-1 bg-green-500 rounded-full"></span>
                            {{ $schedule->bus->capacity }} seats
                        </span>
                        
                        <button class="bg-[#001233] hover:bg-blue-900 text-white font-bold py-2 px-6 rounded-full shadow transition flex items-center gap-2">
                            Select Seat
                        </button>
                    </div>
                </div>
            </div>
            
            @empty
                @if(request()->has('origin'))
                <div class="text-center py-12">
                    <div class="text-gray-300 mb-4">
                         <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-700">No trips found</h3>
                    <p class="text-gray-500">Try changing your date or destination.</p>
                </div>
                @endif
            @endforelse

        </div>
    </div>

    <footer class="bg-[#001233] text-white py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-sm">© 2025 BusPH. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>