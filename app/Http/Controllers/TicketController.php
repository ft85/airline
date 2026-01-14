<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Airline;
use App\Models\Invoice;
use App\Models\Commission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['airline', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $airlines = Airline::where('is_active', true)->get();
        return view('tickets.create', compact('airlines'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
            'travel_date' => 'required|date',
            'pnr_number' => 'required|string|max:255',
            'ticket_number' => 'required|string|max:255',
            'passenger_name' => 'required|string|max:255',
            'trip_type' => 'required|in:one_way,return',
            'departure_airport' => 'required|string|size:3',
            'arrival_airport' => 'required|string|size:3',
            'return_airport' => 'nullable|string|size:3',
            'supplier_price' => 'required|numeric|min:0',
            'service_fee' => 'required|numeric|min:0',
            'client_name' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        
        try {
            $airline = Airline::findOrFail($request->airline_id);
            
            // Calculate totals
            $supplierPrice = $request->supplier_price;
            $serviceFee = $request->service_fee;
            $totalAmount = $supplierPrice + $serviceFee;
            $commissionAmount = ($supplierPrice * $airline->commission_percentage) / 100;
            $companyAmount = $serviceFee + $commissionAmount;
            
            // Create routing string
            $routing = $request->departure_airport . '-' . $request->arrival_airport;
            if ($request->trip_type === 'return' && $request->return_airport) {
                $routing .= '-' . $request->return_airport;
            }

            // Create ticket
            $ticket = Ticket::create([
                'airline_id' => $request->airline_id,
                'user_id' => Auth::id(),
                'travel_date' => $request->travel_date,
                'pnr_number' => $request->pnr_number,
                'ticket_number' => $request->ticket_number,
                'passenger_name' => $request->passenger_name,
                'routing' => $routing,
                'trip_type' => $request->trip_type,
                'departure_airport' => $request->departure_airport,
                'arrival_airport' => $request->arrival_airport,
                'return_airport' => $request->return_airport,
                'supplier_price' => $supplierPrice,
                'service_fee' => $serviceFee,
                'total_amount' => $totalAmount,
                'commission_amount' => $commissionAmount,
                'company_amount' => $companyAmount,
                'client_name' => $request->client_name,
                'status' => 'confirmed'
            ]);

            // Create invoice
            $invoice = Invoice::create([
                'invoice_number' => Invoice::generateInvoiceNumber(),
                'ticket_id' => $ticket->id,
                'user_id' => Auth::id(),
                'client_name' => $request->client_name,
                'total_amount' => $totalAmount,
                'invoice_date' => now(),
                'status' => 'sent'
            ]);

            // Create commission record
            Commission::create([
                'ticket_id' => $ticket->id,
                'airline_id' => $request->airline_id,
                'user_id' => Auth::id(),
                'commission_percentage' => $airline->commission_percentage,
                'commission_amount' => $commissionAmount,
                'supplier_amount' => $supplierPrice - $commissionAmount,
                'company_amount' => $companyAmount,
                'commission_date' => now()
            ]);

            DB::commit();

            return redirect()->route('tickets.show', $ticket)
                ->with('success', 'Ticket created successfully with Invoice #' . $invoice->invoice_number);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to create ticket: ' . $e->getMessage()]);
        }
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['airline', 'user', 'invoice']);
        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $airlines = Airline::where('is_active', true)->get();
        return view('tickets.edit', compact('ticket', 'airlines'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);

        $ticket->update($request->only('status'));

        return redirect()->route('tickets.show', $ticket)
            ->with('success', 'Ticket updated successfully');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return redirect()->route('tickets.index')
            ->with('success', 'Ticket deleted successfully');
    }

    public function calculatePrice(Request $request)
    {
        $airline = Airline::find($request->airline_id);
        $supplierPrice = $request->supplier_price ?? 0;
        $serviceFee = $request->service_fee ?? 0;
        
        if (!$airline) {
            return response()->json(['error' => 'Airline not found'], 404);
        }

        $totalAmount = $supplierPrice + $serviceFee;
        $commissionAmount = ($supplierPrice * $airline->commission_percentage) / 100;
        $companyAmount = $serviceFee + $commissionAmount;
        $supplierAmount = $supplierPrice - $commissionAmount;

        return response()->json([
            'total_amount' => number_format($totalAmount, 2),
            'commission_amount' => number_format($commissionAmount, 2),
            'company_amount' => number_format($companyAmount, 2),
            'supplier_amount' => number_format($supplierAmount, 2),
            'commission_percentage' => $airline->commission_percentage
        ]);
    }
}
