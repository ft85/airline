<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Client Details') }}: {{ $client->name }}</h2>
            <a href="{{ route('clients.edit', $client) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <!-- Client Info & Balance -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
                        <p><strong>Email:</strong> {{ $client->email ?? '-' }}</p>
                        <p><strong>Phone:</strong> {{ $client->phone ?? '-' }}</p>
                        <p><strong>Company:</strong> {{ $client->company ?? '-' }}</p>
                        <p><strong>Address:</strong> {{ $client->address ?? '-' }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Balance Summary</h3>
                        <p><strong>Total Owed:</strong> <span class="text-red-600">${{ number_format($totalOwed, 2) }}</span></p>
                        <p><strong>Total Paid:</strong> <span class="text-green-600">${{ number_format($totalPaid, 2) }}</span></p>
                        <p><strong>Credit Limit:</strong> ${{ number_format($client->credit_limit, 2) }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Record Payment</h3>
                        <form method="POST" action="{{ route('clients.record-payment', $client) }}">
                            @csrf
                            <input type="hidden" name="currency_id" value="1">
                            <div class="mb-2">
                                <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" required class="w-full text-sm rounded border-gray-300">
                            </div>
                            <div class="mb-2">
                                <input type="number" name="amount" placeholder="Amount" step="0.01" min="0.01" required class="w-full text-sm rounded border-gray-300">
                            </div>
                            <div class="mb-2">
                                <select name="payment_method" required class="w-full text-sm rounded border-gray-300">
                                    <option value="cash">Cash</option>
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="mobile_money">Mobile Money</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <input type="text" name="reference" placeholder="Reference" class="w-full text-sm rounded border-gray-300">
                            </div>
                            <button type="submit" class="w-full bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm">Record Payment</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Invoices -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Invoices</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Invoice #</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Paid</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Due</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($client->invoices as $invoice)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $invoice->invoice_number }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $invoice->invoice_date->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 text-sm text-right">${{ number_format($invoice->total_amount, 2) }}</td>
                                    <td class="px-4 py-2 text-sm text-right text-green-600">${{ number_format($invoice->amount_paid, 2) }}</td>
                                    <td class="px-4 py-2 text-sm text-right text-red-600">${{ number_format($invoice->amount_due, 2) }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="px-2 py-1 text-xs rounded-full {{ $invoice->status == 'paid' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ ucfirst($invoice->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-2 text-center text-gray-500">No invoices found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Payment History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Payment History</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Reference</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($client->payments as $payment)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $payment->payment_date->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 text-sm">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $payment->reference ?? '-' }}</td>
                                    <td class="px-4 py-2 text-sm text-right font-medium text-green-600">${{ number_format($payment->amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-2 text-center text-gray-500">No payments recorded.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
