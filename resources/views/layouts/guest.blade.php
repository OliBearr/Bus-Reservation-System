<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Laravel') }}</title>
        
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body style="margin: 0; padding: 0; font-family: sans-serif;">
        
        <div style="position: relative; min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #333;">
            
            <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; z-index: 0; overflow: hidden;">
                <img src="https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=2071&auto=format&fit=crop" 
                     alt="Background" 
                     style="width: 100%; height: 100%; object-fit: cover; opacity: 0.6;">
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(30, 27, 75, 0.6);"></div>
            </div>

            <div style="position: relative; z-index: 10; width: 100%; max-width: 400px; padding: 20px;">
                
                <div style="text-align: center; margin-bottom: 20px; color: white;">
                    <a href="/" style="font-size: 2.5rem; font-weight: bold; text-decoration: none; color: white;">
                        <span>🚌</span> BusPH
                    </a>
                </div>

                <div style="background: rgba(255, 255, 255, 0.95); padding: 30px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.2);">
                    {{ $slot }}
                </div>
                
            </div>
        </div>
    </body>
</html>