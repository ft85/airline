<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Supplier Payables Report') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Summary -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="text-lg">Total Payables: <span class="font-bold text-orange-600">${{ number_format($totalPayables, 2) }}</span></div>
                    <div class="text-sm text-gray-500">{{ $suppliers->count() }} suppliers with outstanding balances</div>
                </div>
            </div>

            <!-- Suppliers List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Supplier</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Contact</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount Owed</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($suppliers as $supplier)
                                <tr>
                                    <td class="px-6 py-4 font-medium">{{ $supplier->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">{{ ucfirst($supplier->type) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">
                                        <div>{{ $supplier->contact_person ?? '-' }}</div>
                                        <div>{{ $supplier->phone ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <span class="text-lg font-bold text-orange-600">${{ number_format($supplier->total_owed, 2) }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('suppliers.show', $supplier) }}" class="text-blue-600 hover:text-blue-900">View Details</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No outstanding payables.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
