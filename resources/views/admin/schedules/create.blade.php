<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Schedule a New Trip</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.schedules.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Select Bus</label>
                            <select name="bus_id" class="w-full border rounded py-2 px-3">
                                @foreach($buses as $bus)
                                    <option value="{{ $bus->id }}">{{ $bus->bus_number }} ({{ $bus->type }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Select Route</label>
                            <select name="route_id" class="w-full border rounded py-2 px-3">
                                @foreach($routes as $route)
                                    <option value="{{ $route->id }}">
                                        {{ $route->origin }} -> {{ $route->destination }} (₱{{ $route->price }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Departure Time</label>
                                <input type="datetime-local" name="departure_time" class="w-full border rounded py-2 px-3" required>
                            </div>
                            <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Arrival Time</label>
                                <input type="datetime-local" name="arrival_time" class="w-full border rounded py-2 px-3" required>
                            </div>
                        </div>

                        <button class="bg-blue hover:bg-blue text-black font-bold py-2 px-4 rounded">
                            Save Schedule
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>