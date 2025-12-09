<x-admin-layout>
    <x-slot name="header">
        Trip Schedules
    </x-slot>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm relative" role="alert">
            <p class="font-bold">Success</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif

    <div class="flex justify-between items-center mb-6 gap-4">
        
        <div class="relative w-full md:w-96">
            <input type="text" placeholder="Search bus or route..." 
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-[#001233] focus:border-[#001233] transition text-sm">
            <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <a href="{{ route('admin.schedules.create') }}" class="bg-[#001233] hover:bg-blue-900 text-white font-bold py-2.5 px-6 rounded-lg shadow-md transition flex items-center gap-2 flex-shrink-0">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Schedule New Trip
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Trip Details</th>
                        <th class="px-6 py-4">Bus / Plate</th>
                        <th class="px-6 py-4">Route / Price</th>
                        <th class="px-6 py-4">Departure Time</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($schedules as $schedule)
                    <tr class="hover:bg-gray-50 transition group">
                        
                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-800 text-base">Trip #{{ $schedule->id }}</p>
                            <p class="text-xs text-gray-400">Code: BC{{ $schedule->id }}</p>
                            <p class="text-xs text-gray-400 mt-1">Created: {{ $schedule->created_at->format('M d, Y') }}</p>
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-bold text-[#001233]">{{ $schedule->bus->bus_number }} ({{ $schedule->bus->type }})</p>
                            <p class="text-xs text-gray-500">Plate: {{ $schedule->bus->plate_number ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 mt-1">Capacity: {{ $schedule->bus->capacity }} seats</p>
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-800">
                                {{ $schedule->route->origin }} → {{ $schedule->route->destination }}
                            </p>
                            <p class="text-xs text-gray-500">Fare: ₱ {{ number_format($schedule->route->price, 2) }}</p>
                        </td>

                        <td class="px-6 py-4">
                            <p class="font-bold text-gray-800">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('M d, Y') }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($schedule->departure_time)->format('h:i A') }}</p>
                        </td>

                        <td class="px-6 py-4">
                            @if(\Carbon\Carbon::parse($schedule->departure_time)->isFuture())
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                    Scheduled
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-600 border border-gray-200">
                                    Completed
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition" title="Edit Schedule">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                </a>
                                <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this schedule?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <p class="text-lg font-medium text-gray-500">No trips scheduled yet.</p>
                            <p class="text-sm text-gray-400 mt-1">Click the button above to schedule your first trip.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>