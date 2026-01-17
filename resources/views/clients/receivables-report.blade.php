<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Client Receivables Report') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="text-lg">Total Receivables: <span class="font-bold text-red-600">${{ number_format($totalReceivables, 2) }}</span></div>
                    <div class="text-sm text-gray-500">{{ $clients->count() }} clients with outstanding balances</div>
                </div>
            </div>

            <!-- Clients List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount Owed</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($clients as $client)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="font-medium">{{ $client->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $client->company ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div>{{ $client->email ?? '-' }}</div>
                                        <div>{{ $client->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-lg font-bold text-red-600">${{ number_format($client->total_owed, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('clients.show', $client) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No outstanding receivables.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
