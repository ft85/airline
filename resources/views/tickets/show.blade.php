<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-700 -mx-4 -mt-4 px-4 pt-4 pb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Ticket Details</h1>
                    <p class="text-indigo-100 mt-1">{{ $ticket->ticket_number }} - {{ $ticket->passenger_name }}</p>
                </div>
                <div class="flex space-x-3">
                    @if($ticket->invoice)
                        <a href="{{ route('invoices.print', $ticket->invoice) }}" 
                           class="btn-primary" target="_blank">
                            <svg class="w-5 h-5 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"></path>
                            </svg>
                            Print Invoice
                        </a>
                    @endif
                    <a href="{{ route('tickets.index') }}" class="btn-secondary">
                        <svg class="w-5 h-5 mr-2 inline" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Back to Tickets
                    </a>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Ticket Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Flight Information</h3>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Travel Date</label>
                                    <p class="text-sm text-gray-900">{{ $ticket->travel_date->format('M d, Y') }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Trip Type</label>
                                    <p class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $ticket->trip_type)) }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Airline</label>
                                <p class="text-sm text-gray-900">{{ $ticket->airline->name }} ({{ $ticket->airline->code }})</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">PNR Number</label>
                                    <p class="text-sm text-gray-900">{{ $ticket->pnr_number }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Ticket Number</label>
                                    <p class="text-sm text-gray-900">{{ $ticket->ticket_number }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Routing</label>
                                <p class="text-sm text-gray-900">{{ $ticket->routing }}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Passenger Name</label>
                                    <p class="text-sm text-gray-900">{{ $ticket->passenger_name }}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Client Name</label>
                                    <p class="text-sm text-gray-900">{{ $ticket->client_name }}</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($ticket->status === 'confirmed') bg-green-100 text-green-800
                                    @elseif($ticket->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($ticket->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Breakdown</h3>
                        
                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-2 gap-4 mb-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Supplier Price</label>
                                        <p class="text-lg font-semibold text-gray-900">${{ number_format($ticket->supplier_price, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Service Fee</label>
                                        <p class="text-lg font-semibold text-gray-900">${{ number_format($ticket->service_fee, 2) }}</p>
                                    </div>
                                </div>
                                <div class="border-t pt-2">
                                    <label class="block text-sm font-medium text-gray-700">Total Amount (Customer Pays)</label>
                                    <p class="text-xl font-bold text-green-600">${{ number_format($ticket->total_amount, 2) }}</p>
                                </div>
                            </div>

                            <div class="bg-blue-50 p-4 rounded-lg">
                                <h4 class="font-medium text-gray-900 mb-2">Commission Breakdown</h4>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Commission Rate</label>
                                        <p class="text-sm text-gray-900">{{ $ticket->airline->commission_percentage }}%</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Commission Amount</label>
                                        <p class="text-sm font-semibold text-blue-600">${{ number_format($ticket->commission_amount, 2) }}</p>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mt-2">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Amount to Supplier</label>
                                        <p class="text-sm font-semibold text-orange-600">${{ number_format($ticket->supplier_price - $ticket->commission_amount, 2) }}</p>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Company Keeps</label>
                                        <p class="text-sm font-semibold text-purple-600">${{ number_format($ticket->company_amount, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($ticket->invoice)
                <!-- Invoice Information -->
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Invoice Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Invoice Number</label>
                                <p class="text-sm font-semibold text-gray-900">{{ $ticket->invoice->invoice_number }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Invoice Date</label>
                                <p class="text-sm text-gray-900">{{ $ticket->invoice->invoice_date->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($ticket->invoice->status === 'paid') bg-green-100 text-green-800
                                    @elseif($ticket->invoice->status === 'sent') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($ticket->invoice->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Actions</label>
                                <a href="{{ route('invoices.print', $ticket->invoice) }}" 
                                   class="text-blue-600 hover:text-blue-900" target="_blank">
                                    Print Invoice
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
