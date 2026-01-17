<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Clients') }}</h2>
            <a href="{{ route('clients.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Client
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <!-- Search -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('clients.index') }}" class="flex space-x-4">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search clients..."
                            class="flex-1 rounded-md border-gray-300 shadow-sm">
                        <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Search</button>
                    </form>
                </div>
            </div>

            <!-- Clients Table -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Company</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Total Owed</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($clients as $client)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap font-medium">{{ $client->name }}</td>
                                    <td class="px-6 py-4 text-sm">
                                        <div>{{ $client->email ?? '-' }}</div>
                                        <div class="text-gray-500">{{ $client->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $client->company ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        @if($client->total_owed > 0)
                                            <span class="text-red-600 font-medium">${{ number_format($client->total_owed, 2) }}</span>
                                        @else
                                            <span class="text-green-600">$0.00</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $client->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $client->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                        <a href="{{ route('clients.show', $client) }}" class="text-green-600 hover:text-green-900 mr-3">View</a>
                                        <a href="{{ route('clients.edit', $client) }}" class="text-blue-600 hover:text-blue-900 mr-3">Edit</a>
                                        <form action="{{ route('clients.destroy', $client) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this client?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No clients found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">{{ $clients->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
