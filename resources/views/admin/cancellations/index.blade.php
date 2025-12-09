<x-admin-layout>
    <x-slot name="header">Cancellation Requests</x-slot>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm relative" role="alert"><p>{{ session('success') }}</p></div>
    @endif
    @if(session('warning'))
        <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded shadow-sm relative" role="alert"><p>{{ session('warning') }}</p></div>
    @endif
    @if(session('error'))
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm relative" role="alert"><p>{{ session('error') }}</p></div>
    @endif
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-gray-600">
                <thead class="bg-gray-50 text-xs uppercase font-bold text-gray-500 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Booking ID / Passenger</th>
                        <th class="px-6 py-4">Route / Departure</th>
                        <th class="px-6 py-4">Reason</th>
                        <th class="px-6 py-4">Requested On</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($requests as $reservation)
                    <tr class="hover:bg-yellow-50 transition">
                        <td class="px-6 py-4">
                            <p class="font-mono font-bold text-yellow-800">#{{ $reservation->id }}</p>
                            <p class="font-bold text-gray-800">{{ $reservation->user->name }}</p>
                            <p class="text-xs text-gray-400">{{ $reservation->user->email }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="font-medium text-[#001233]">{{ $reservation->schedule->route->origin }} → {{ $reservation->schedule->route->destination }}</p>
                            <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reservation->schedule->departure_time)->format('M d, Y • h:i A') }}</p>
                        </td>
                        <td class="px-6 py-4 italic max-w-sm overflow-hidden text-ellipsis">
                            "{{ $reservation->cancellation_reason }}"
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $reservation->updated_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex flex-col gap-2 items-center">
                                
                                <form action="{{ route('admin.cancellations.approve', $reservation->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" onclick="return confirm('APPROVE CANCELLATION for #{{ $reservation->id }}? This will permanently cancel the booking.');"
                                            class="bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 transition text-sm">
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('admin.cancellations.reject', $reservation->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <button type="submit" onclick="return confirm('REJECT CANCELLATION for #{{ $reservation->id }}? This will reactivate the booking.');"
                                            class="text-red-600 hover:text-red-700 font-bold py-1 px-4 rounded-lg hover:bg-red-50 transition text-xs border border-red-200">
                                        Reject
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">No pending cancellation requests.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-100">
            {{ $requests->links() }}
        </div>
    </div>
</x-admin-layout>