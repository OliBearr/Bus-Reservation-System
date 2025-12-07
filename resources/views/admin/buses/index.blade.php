<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Manage Buses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <a href="{{ route('admin.buses.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-black font-bold py-2 px-4 rounded shadow-md mb-4 inline-block">
                        + Add New Bus
                    </a>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <table class="min-w-full leading-normal mt-4">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Bus Number</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Capacity</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($buses as $bus)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $bus->bus_number }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $bus->type }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $bus->capacity }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>