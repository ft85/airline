<x-app-layout>
    <x-slot name="header">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 -mx-4 -mt-4 px-4 pt-4 pb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white">Create New Ticket</h1>
                    <p class="text-blue-100 mt-1">Book a new airline ticket with automatic commission calculation</p>
                </div>
                <div>
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
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="card-modern">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('tickets.store') }}" id="ticketForm">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div>
                                    <label for="travel_date" class="block text-sm font-medium text-gray-700">Travel Date</label>
                                    <input type="date" name="travel_date" id="travel_date" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('travel_date') }}">
                                    @error('travel_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="airline_id" class="block text-sm font-medium text-gray-700">Airline</label>
                                    <select name="airline_id" id="airline_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Airline</option>
                                        @foreach($airlines as $airline)
                                            <option value="{{ $airline->id }}" {{ old('airline_id') == $airline->id ? 'selected' : '' }}>
                                                {{ $airline->name }} ({{ $airline->code }}) - {{ $airline->commission_percentage }}% Commission
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('airline_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="pnr_number" class="block text-sm font-medium text-gray-700">PNR Number</label>
                                    <input type="text" name="pnr_number" id="pnr_number" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('pnr_number') }}" placeholder="e.g., ABCD123">
                                    @error('pnr_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="ticket_number" class="block text-sm font-medium text-gray-700">Ticket Number</label>
                                    <input type="text" name="ticket_number" id="ticket_number" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('ticket_number') }}" placeholder="e.g., 071-2400775642">
                                    @error('ticket_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="passenger_name" class="block text-sm font-medium text-gray-700">Passenger Name</label>
                                    <input type="text" name="passenger_name" id="passenger_name" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('passenger_name') }}" placeholder="e.g., JOHN DOE">
                                    @error('passenger_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="client_name" class="block text-sm font-medium text-gray-700">Client Name</label>
                                    <input type="text" name="client_name" id="client_name" required
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('client_name') }}" placeholder="e.g., KENYA CLIENT">
                                    @error('client_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div>
                                    <label for="trip_type" class="block text-sm font-medium text-gray-700">Trip Type</label>
                                    <select name="trip_type" id="trip_type" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="one_way" {{ old('trip_type') == 'one_way' ? 'selected' : '' }}>One Way</option>
                                        <option value="return" {{ old('trip_type') == 'return' ? 'selected' : '' }}>Return</option>
                                    </select>
                                    @error('trip_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="departure_airport" class="block text-sm font-medium text-gray-700">Departure Airport</label>
                                    <input type="text" name="departure_airport" id="departure_airport" required maxlength="3"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('departure_airport') }}" placeholder="e.g., BJM" style="text-transform: uppercase;">
                                    @error('departure_airport')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="arrival_airport" class="block text-sm font-medium text-gray-700">Arrival Airport</label>
                                    <input type="text" name="arrival_airport" id="arrival_airport" required maxlength="3"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('arrival_airport') }}" placeholder="e.g., KGL" style="text-transform: uppercase;">
                                    @error('arrival_airport')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div id="return_airport_div" style="display: none;">
                                    <label for="return_airport" class="block text-sm font-medium text-gray-700">Return Airport</label>
                                    <input type="text" name="return_airport" id="return_airport" maxlength="3"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('return_airport') }}" placeholder="e.g., BJM" style="text-transform: uppercase;">
                                    @error('return_airport')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="supplier_price" class="block text-sm font-medium text-gray-700">Supplier Price ($)</label>
                                    <input type="number" name="supplier_price" id="supplier_price" required min="0" step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('supplier_price') }}" placeholder="e.g., 100.00">
                                    @error('supplier_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="service_fee" class="block text-sm font-medium text-gray-700">Service Fee ($)</label>
                                    <input type="number" name="service_fee" id="service_fee" required min="0" step="0.01"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                           value="{{ old('service_fee') }}" placeholder="e.g., 20.00">
                                    @error('service_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Calculation Results -->
                        <div class="mt-8 p-4 bg-gray-50 rounded-lg" id="calculationResults" style="display: none;">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Price Breakdown</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                                    <p class="text-lg font-semibold text-green-600" id="total_amount_display">$0.00</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Commission</label>
                                    <p class="text-lg font-semibold text-blue-600" id="commission_amount_display">$0.00</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Company Amount</label>
                                    <p class="text-lg font-semibold text-purple-600" id="company_amount_display">$0.00</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Supplier Amount</label>
                                    <p class="text-lg font-semibold text-orange-600" id="supplier_amount_display">$0.00</p>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end space-x-4">
                            <a href="{{ route('tickets.index') }}" 
                               class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Create Ticket & Generate Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tripTypeSelect = document.getElementById('trip_type');
            const returnAirportDiv = document.getElementById('return_airport_div');
            const airlineSelect = document.getElementById('airline_id');
            const supplierPriceInput = document.getElementById('supplier_price');
            const serviceFeeInput = document.getElementById('service_fee');
            const calculationResults = document.getElementById('calculationResults');

            // Show/hide return airport based on trip type
            tripTypeSelect.addEventListener('change', function() {
                if (this.value === 'return') {
                    returnAirportDiv.style.display = 'block';
                } else {
                    returnAirportDiv.style.display = 'none';
                }
            });

            // Auto-calculate prices when inputs change
            function calculatePrices() {
                const airlineId = airlineSelect.value;
                const supplierPrice = parseFloat(supplierPriceInput.value) || 0;
                const serviceFee = parseFloat(serviceFeeInput.value) || 0;

                if (airlineId && (supplierPrice > 0 || serviceFee > 0)) {
                    fetch('{{ route("tickets.calculate-price") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            airline_id: airlineId,
                            supplier_price: supplierPrice,
                            service_fee: serviceFee
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('total_amount_display').textContent = '$' + data.total_amount;
                        document.getElementById('commission_amount_display').textContent = '$' + data.commission_amount;
                        document.getElementById('company_amount_display').textContent = '$' + data.company_amount;
                        document.getElementById('supplier_amount_display').textContent = '$' + data.supplier_amount;
                        calculationResults.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                }
            }

            airlineSelect.addEventListener('change', calculatePrices);
            supplierPriceInput.addEventListener('input', calculatePrices);
            serviceFeeInput.addEventListener('input', calculatePrices);

            // Initialize trip type visibility
            if (tripTypeSelect.value === 'return') {
                returnAirportDiv.style.display = 'block';
            }
        });
    </script>
</x-app-layout>
