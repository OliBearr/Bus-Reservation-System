<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add New Route</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.routes.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Origin (From)</label>
                            <input type="text" name="origin" placeholder="e.g. Manila" class="shadow border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Destination (To)</label>
                            <input type="text" name="destination" placeholder="e.g. Baguio" class="shadow border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Price (PHP)</label>
                            <input type="number" step="0.01" name="price" placeholder="500.00" class="shadow border rounded w-full py-2 px-3 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        </div>

                        <button class="bg-indigo-600 hover:bg-indigo-700 text-black font-bold py-2 px-4 rounded shadow-md transition duration-150">
                            Save Route
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>