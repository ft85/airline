<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Supplier Details') }}: {{ $supplier->name }}</h2>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('success') }}</div>
            @endif

            <!-- Supplier Info & Balance -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Contact Information</h3>
                        <p><strong>Type:</strong> {{ ucfirst($supplier->type) }}</p>
                        <p><strong>Contact:</strong> {{ $supplier->contact_person ?? '-' }}</p>
                        <p><strong>Email:</strong> {{ $supplier->email ?? '-' }}</p>
                        <p><strong>Phone:</strong> {{ $supplier->phone ?? '-' }}</p>
                        <p><strong>Address:</strong> {{ $supplier->address ?? '-' }}</p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Balance Summary</h3>
                        <p><strong>We Owe:</strong> <span class="text-orange-600">${{ number_format($totalOwed, 2) }}</span></p>
                        <p><strong>Total Paid:</strong> <span class="text-green-600">${{ number_format($totalPaid, 2) }}</span></p>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Record Payment</h3>
                        <form method="POST" action="{{ route('suppliers.record-payment', $supplier) }}">
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
                                    <option value="bank_transfer">Bank Transfer</option>
                                    <option value="cash">Cash</option>
                                    <option value="mobile_money">Mobile Money</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <input type="text" name="reference" placeholder="Reference" class="w-full text-sm rounded border-gray-300">
                            </div>
                            <button type="submit" class="w-full bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded text-sm">Record Payment</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tickets/Transactions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Tickets</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ticket #</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Passenger</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Supplier Price</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Paid</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Due</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($supplier->tickets as $ticket)
                                <tr>
                                    <td class="px-4 py-2 text-sm">{{ $ticket->ticket_number }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $ticket->travel_date->format('M d, Y') }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $ticket->passenger_name }}</td>
                                    <td class="px-4 py-2 text-sm text-right">${{ number_format($ticket->supplier_price, 2) }}</td>
                                    <td class="px-4 py-2 text-sm text-right text-green-600">${{ number_format($ticket->supplier_paid, 2) }}</td>
                                    <td class="px-4 py-2 text-sm text-right text-orange-600">${{ number_format($ticket->supplier_due, 2) }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-2 text-center text-gray-500">No tickets found.</td></tr>
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
                            @forelse($supplier->payments as $payment)
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
