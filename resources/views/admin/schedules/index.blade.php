<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">Manage Schedules</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a href="{{ route('admin.schedules.create') }}" class="bg-indigo-600 hover:bg-white-700 text-black font-bold py-2 px-4 rounded shadow-md mb-4 inline-block">
                        + Schedule New Trip
                    </a>

                    <table class="min-w-full leading-normal mt-4">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Bus</th>
                                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Route</th>
                                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Departure</th>
                                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                                <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                            <tr>
                                <td class="px-5 py-5 bg-white text-sm">
                                    <div class="font-bold">{{ $schedule->bus->bus_number }}</div>
                                    <div class="text-xs text-gray-500">{{ $schedule->bus->type }}</div>
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    {{ $schedule->route->origin }} ➝ {{ $schedule->route->destination }}
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    {{ \Carbon\Carbon::parse($schedule->departure_time)->format('M d, Y h:i A') }}
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                </td>
                                <td class="px-5 py-5 bg-white text-sm">
                                    <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Delete this schedule?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-600 hover:text-red-900">Delete</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>