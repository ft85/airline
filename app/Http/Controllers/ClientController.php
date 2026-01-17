<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientPayment;
use App\Models\Currency;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = Client::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('company', 'like', "%{$search}%");
            });
        }

        $clients = $query->withSum('invoices as total_owed', 'amount_due')
            ->withSum('payments as total_paid', 'amount_base')
            ->orderBy('name')
            ->paginate(20);

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Client created successfully.');
    }

    public function show(Client $client)
    {
        $client->load(['invoices.currency', 'payments.currency', 'tickets']);
        
        $totalOwed = $client->invoices->sum('amount_due');
        $totalPaid = $client->payments->sum('amount_base');

        return view('clients.show', compact('client', 'totalOwed', 'totalPaid'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'credit_limit' => 'nullable|numeric|min:0',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $client->update($validated);

        return redirect()->route('clients.index')->with('success', 'Client updated successfully.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Client deleted successfully.');
    }

    public function recordPayment(Request $request, Client $client)
    {
        $validated = $request->validate([
            'invoice_id' => 'nullable|exists:invoices,id',
            'currency_id' => 'required|exists:currencies,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,credit_card,check',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $validated['client_id'] = $client->id;
        $validated['user_id'] = auth()->id();

        $currency = Currency::find($validated['currency_id']);
        $validated['amount_base'] = $currency->convertToBase($validated['amount']);

        ClientPayment::create($validated);

        return redirect()->route('clients.show', $client)->with('success', 'Payment recorded successfully.');
    }

    public function receivablesReport()
    {
        $clients = Client::withSum('invoices as total_owed', 'amount_due')
            ->having('total_owed', '>', 0)
            ->orderByDesc('total_owed')
            ->get();

        $totalReceivables = $clients->sum('total_owed');

        return view('clients.receivables-report', compact('clients', 'totalReceivables'));
    }
}
