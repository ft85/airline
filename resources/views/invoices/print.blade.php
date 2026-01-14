<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .company-name {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .company-details {
            font-size: 12px;
            color: #666;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .invoice-details, .client-details {
            width: 48%;
        }
        .invoice-details h3, .client-details h3 {
            margin-bottom: 10px;
            font-size: 16px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .ticket-details {
            margin-bottom: 30px;
        }
        .ticket-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .ticket-table th, .ticket-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .ticket-table th {
            background-color: #f5f5f5;
            font-weight: bold;
        }
        .total-section {
            text-align: right;
            margin-top: 20px;
        }
        .total-amount {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #2563eb; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">
            Print Invoice
        </button>
        <button onclick="window.close()" style="background: #6b7280; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
            Close
        </button>
    </div>

    <div class="invoice-header">
        <div class="company-name">AIRLINE TICKET AGENCY</div>
        <div class="company-details">
            Professional Travel Services | Phone: +250-XXX-XXXX | Email: info@airlineagency.com
        </div>
    </div>

    <div class="invoice-info">
        <div class="invoice-details">
            <h3>Invoice Details</h3>
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Invoice Date:</strong> {{ $invoice->invoice_date->format('M d, Y') }}</p>
            <p><strong>Status:</strong> 
                <span style="color: {{ $invoice->status === 'paid' ? '#10b981' : ($invoice->status === 'sent' ? '#f59e0b' : '#6b7280') }}">
                    {{ ucfirst($invoice->status) }}
                </span>
            </p>
            <p><strong>Issued By:</strong> {{ $invoice->user->name }}</p>
        </div>

        <div class="client-details">
            <h3>Client Information</h3>
            <p><strong>Client Name:</strong> {{ $invoice->client_name }}</p>
            <p><strong>Passenger:</strong> {{ $invoice->ticket->passenger_name }}</p>
            <p><strong>Travel Date:</strong> {{ $invoice->ticket->travel_date->format('M d, Y') }}</p>
        </div>
    </div>

    <div class="ticket-details">
        <h3>Flight Details</h3>
        <table class="ticket-table">
            <thead>
                <tr>
                    <th>Airline</th>
                    <th>PNR</th>
                    <th>Ticket Number</th>
                    <th>Route</th>
                    <th>Trip Type</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $invoice->ticket->airline->name }} ({{ $invoice->ticket->airline->code }})</td>
                    <td>{{ $invoice->ticket->pnr_number }}</td>
                    <td>{{ $invoice->ticket->ticket_number }}</td>
                    <td>{{ $invoice->ticket->routing }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $invoice->ticket->trip_type)) }}</td>
                    <td>${{ number_format($invoice->total_amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="total-section">
        <table style="margin-left: auto; width: 300px;">
            <tr style="border-top: 2px solid #333;">
                <td style="padding: 10px; text-align: right;"><strong>Total Amount:</strong></td>
                <td style="padding: 10px; text-align: right;" class="total-amount">${{ number_format($invoice->total_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p><strong>Thank you for choosing our services!</strong></p>
        <p>This is a computer-generated invoice. No signature required.</p>
        <p>Generated on {{ now()->format('M d, Y H:i') }}</p>
    </div>
</body>
</html>
