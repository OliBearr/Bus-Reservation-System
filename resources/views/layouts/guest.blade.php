<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'BusPH') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex">
            
            <div class="hidden lg:flex lg:w-1/2 bg-[#001233] items-center justify-center">
                <div class="text-center p-10">
                    <img src="{{ asset('images/logo.png') }}" alt="BusPH Logo" class="w-64 h-auto mx-auto">
                </div>
            </div>

            <div class="w-full lg:w-1/2 flex items-center justify-center bg-[#F8F9FA] px-8 py-12">
                <div class="w-full max-w-lg space-y-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>