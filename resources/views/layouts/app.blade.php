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
                    </div>
                </div>
            </nav>

            <main class="flex-grow flex flex-col">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>