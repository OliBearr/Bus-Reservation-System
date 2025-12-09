<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'BusPH') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-[#F3F4F6]">
        
        <div class="min-h-screen flex flex-col">
            
            <nav x-data="{ open: false }" class="bg-[#001233] text-white border-b border-gray-800 shadow-md z-50">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        
                        <div class="flex items-center gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                            @else
                                <a href="{{ url('/') }}" class="flex items-center gap-2">
                            @endauth
                                    <img src="{{ asset('images/logo.png') }}" alt="BusPH" class="h-10 w-auto">
                                    <span class="font-bold text-xl tracking-tight text-white">BusPH</span>
                                </a>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                        @auth
                                            <span class="user-name">{{ Auth::user()->name }}</span>
                                            {{-- Role check for Admin Panel link --}}
                                            @if (Auth::user()->role === 'admin')
                                                <span class="ml-2 text-xs bg-red-600 px-2 py-0.5 rounded">Admin</span>
                                            @endif
                                        @else
                                            <span>Guest</span>
                                        @endauth
                                        <div class="ms-1">
                                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    @auth
                                        <x-dropdown-link :href="route('user.bookings.index')">
                                            {{ __('My Bookings') }}
                                        </x-dropdown-link>
                                        
                                        <x-dropdown-link :href="route('profile.edit')">
                                            {{ __('Profile') }}
                                        </x-dropdown-link>

                                        @if (Auth::user()->role === 'admin')
                                            <x-dropdown-link :href="route('admin.dashboard')">
                                                {{ __('Admin Panel') }}
                                            </x-dropdown-link>
                                        @endif
                                        
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </x-dropdown-link>
                                        </form>
                                    @else
                                        <x-dropdown-link :href="route('login')">
                                            {{ __('Login') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('register')">
                                            {{ __('Register') }}
                                        </x-dropdown-link>
                                    @endauth
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                    <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#001233] border-t border-gray-700">
                    <div class="pt-2 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-white">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                    </div>
                    
                    @auth
                        <div class="pt-4 pb-1 border-t border-gray-700">
                            <div class="px-4">
                                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                                <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                            </div>
                            
                            <div class="mt-3 space-y-1">
                                <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 hover:text-white">
                                    {{ __('Profile') }}
                                </x-responsive-nav-link>

                                @if (Auth::user()->role === 'admin')
                                    <x-responsive-nav-link :href="route('admin.dashboard')" class="text-gray-300 hover:text-white">
                                        {{ __('Admin Panel') }}
                                    </x-responsive-nav-link>
                                @endif

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-responsive-nav-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();" class="text-gray-300 hover:text-white">
                                        {{ __('Log Out') }}
                                    </x-responsive-nav-link>
                                </form>
                            </div>
                        </div>
                    @else
                        {{-- Mobile Guest Links --}}
                        <div class="pt-4 pb-1 border-t border-gray-700">
                            <x-responsive-nav-link :href="route('login')" class="text-gray-300 hover:text-white">
                                {{ __('Login') }}
                            </x-responsive-nav-link>
                            <x-responsive-nav-link :href="route('register')" class="text-gray-300 hover:text-white">
                                {{ __('Register') }}
                            </x-responsive-nav-link>
                        </div>
                    @endauth
                    
                </div>
            </nav>

            <main class="flex-grow flex flex-col">
                {{ $slot }}
            </main>

        </div>
        
        <script>
        function openCancellationModal(reservationId) {
            const modal = document.getElementById('cancellation-modal');
            const form = document.getElementById('cancellation-form');
            
            // Set the form action dynamically (This logic is correct)
            const route = "{{ route('user.bookings.cancel', ['reservation' => 'RESERVATION_ID']) }}";
            form.action = route.replace('RESERVATION_ID', reservationId);
            
            modal.classList.remove('hidden');
        }

        function closeCancellationModal() {
            document.getElementById('cancellation-modal').classList.add('hidden');
        }
        </script>
        
        {{-- The modal now opens if validation fails --}}
        <div id="cancellation-modal" 
             class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4 
                    {{ $errors->any() ? '' : 'hidden' }}"> 
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md overflow-hidden">
                
                <div class="bg-red-600 p-4 flex justify-between items-center text-white">
                    <h3 class="text-xl font-bold">Confirm Trip Cancellation</h3>
                    <button onclick="closeCancellationModal()" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <form id="cancellation-form" method="POST" action="">
                    @csrf
                    <div class="p-6">
                        <p class="mb-4 text-gray-700">Are you sure you want to cancel this booking? The cancellation will be finalized after administrative review.</p>
                        <p class="font-bold text-red-600 mb-4">Note: Funds will be returned based on our refund policy.</p>
                        
                        <label for="cancellation_reason" class="block text-sm font-bold text-gray-700 mb-2">
                            Reason for Cancellation (Required)
                        </label>
                        <textarea name="cancellation_reason" id="cancellation_reason" rows="4" 
                                class="w-full rounded-lg border-gray-300 focus:border-red-500 focus:ring-red-500" required></textarea>
                        
                        {{-- Display Validation Errors --}}
                        @error('cancellation_reason')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="p-4 bg-gray-50 flex justify-end gap-3">
                        <button type="button" onclick="closeCancellationModal()" class="py-2 px-4 rounded-lg text-gray-700 hover:bg-gray-200 transition">
                            Keep Booking
                        </button>
                        <button type="submit" class="py-2 px-4 rounded-lg bg-red-600 text-white font-bold hover:bg-red-700 transition">
                            Request Cancellation
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>