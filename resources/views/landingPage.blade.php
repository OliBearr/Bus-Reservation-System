<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bus Reservation System</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-sans">

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center">
                    <span class="text-2xl font-bold text-indigo-600">🚌 BusPH</span>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @if (Route::has('login'))
                        <div class="space-x-4">
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Admin Panel</a>
                                @else
                                    <a href="{{ url('/dashboard') }}" class="text-gray-700 hover:text-indigo-600 font-medium">My Dashboard</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 font-medium">Log in</a>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium transition">Register</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <div class="relative bg-indigo-900 text-white overflow-hidden">
        <div class="absolute inset-0">
            <img class="w-full h-full object-cover opacity-30" src="https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2069&auto=format&fit=crop" alt="Bus Travel">
        </div>
        
        <div class="relative max-w-7xl mx-auto py-24 px-4 sm:px-6 lg:px-8 flex flex-col items-center text-center">
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight mb-4">
                Travel with Comfort & Safety
            </h1>
            <p class="text-lg md:text-xl text-indigo-100 mb-10 max-w-2xl">
                Book your tickets online instantly. Choose your seat, pay securely, and enjoy the ride across the country.
            </p>

            <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-4xl text-gray-800 grid grid-cols-1 md:grid-cols-4 gap-4 items-end">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 text-left">From</label>
                    <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                        <option>Select Origin</option>
                        <option>Manila</option>
                        <option>Cubao</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 text-left">To</label>
                    <select class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                        <option>Select Destination</option>
                        <option>Baguio</option>
                        <option>Batangas</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1 text-left">Date</label>
                    <input type="date" class="w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                </div>
                <div>
                    <button class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-150">
                        Search Trips
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-extrabold text-gray-900">Why Choose Us?</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center p-6 border rounded-lg hover:shadow-lg transition">
                    <div class="text-4xl mb-4">⚡</div>
                    <h3 class="text-xl font-bold mb-2">Instant Booking</h3>
                    <p class="text-gray-600">No queues. Book your ticket in less than 2 minutes from your device.</p>
                </div>
                <div class="text-center p-6 border rounded-lg hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🛡️</div>
                    <h3 class="text-xl font-bold mb-2">Secure Payments</h3>
                    <p class="text-gray-600">We accept major credit cards and e-wallets. Your data is always safe.</p>
                </div>
                <div class="text-center p-6 border rounded-lg hover:shadow-lg transition">
                    <div class="text-4xl mb-4">🛋️</div>
                    <h3 class="text-xl font-bold mb-2">Premium Comfort</h3>
                    <p class="text-gray-600">Enjoy reclining seats, air conditioning, and free Wi-Fi on board.</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2025 Bus Reservation System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>