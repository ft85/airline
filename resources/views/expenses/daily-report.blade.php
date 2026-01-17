<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Daily Expenses Report') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Date Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('reports.expenses.daily') }}" class="flex items-end space-x-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Select Date</label>
                            <input type="date" name="date" value="{{ $date }}" class="mt-1 block rounded-md border-gray-300 shadow-sm">
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">View Report</button>
                    </form>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Expenses</div>
                        <div class="text-2xl font-bold text-red-600">${{ number_format($totalExpenses, 2) }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Number of Transactions</div>
                        <div class="text-2xl font-bold">{{ $expenses->count() }}</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Categories Used</div>
                        <div class="text-2xl font-bold">{{ $byCategory->count() }}</div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- By Category -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">By Category</h3>
                        @forelse($byCategory as $item)
                            <div class="flex justify-between items-center py-2 border-b">
                                <span class="px-2 py-1 text-xs rounded-full text-white" style="background-color: {{ $item['category']->color }}">
                                    {{ $item['category']->name }}
                                </span>
                                <span class="font-medium">${{ number_format($item['total'], 2) }} ({{ $item['count'] }})</span>
                            </div>
                        @empty
                            <p class="text-gray-500">No expenses for this date.</p>
                        @endforelse
                    </div>
                </div>

                <!-- By Payment Method -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">By Payment Method</h3>
                        @forelse($byPaymentMethod as $method => $total)
                            <div class="flex justify-between items-center py-2 border-b">
                                <span>{{ ucfirst(str_replace('_', ' ', $method)) }}</span>
                                <span class="font-medium">${{ number_format($total, 2) }}</span>
                            </div>
                        @empty
                            <p class="text-gray-500">No expenses for this date.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Expenses List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Expense Details</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Description</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vendor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Payment</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($expenses as $expense)
                                <tr>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs rounded-full text-white" style="background-color: {{ $expense->category->color }}">
                                            {{ $expense->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm">{{ $expense->description }}</td>
                                    <td class="px-6 py-4 text-sm">{{ $expense->vendor ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm">{{ ucfirst(str_replace('_', ' ', $expense->payment_method)) }}</td>
                                    <td class="px-6 py-4 text-right font-medium">
                                        {{ $expense->currency->symbol }}{{ number_format($expense->amount, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">No expenses for this date.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
