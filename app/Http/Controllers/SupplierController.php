<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\SupplierPayment;
use App\Models\Currency;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('contact_person', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $suppliers = $query->withSum('tickets as total_owed', 'supplier_due')
            ->withSum('payments as total_paid', 'amount_base')
            ->orderBy('name')
            ->paginate(20);

        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'type' => 'required|in:airline,hotel,transport,other',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Supplier::create($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function show(Supplier $supplier)
    {
        $supplier->load(['tickets.currency', 'payments.currency']);
        
        $totalOwed = $supplier->tickets->sum('supplier_due');
        $totalPaid = $supplier->payments->sum('amount_base');

        return view('suppliers.show', compact('supplier', 'totalOwed', 'totalPaid'));
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:255',
            'contact_person' => 'nullable|string|max:255',
            'type' => 'required|in:airline,hotel,transport,other',
            'notes' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $supplier->update($validated);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated successfully.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }

    public function recordPayment(Request $request, Supplier $supplier)
    {
        $validated = $request->validate([
            'ticket_id' => 'nullable|exists:tickets,id',
            'currency_id' => 'required|exists:currencies,id',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,credit_card,check',
            'reference' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $validated['supplier_id'] = $supplier->id;
        $validated['user_id'] = auth()->id();

        $currency = Currency::find($validated['currency_id']);
        $validated['amount_base'] = $currency->convertToBase($validated['amount']);

        SupplierPayment::create($validated);

        return redirect()->route('suppliers.show', $supplier)->with('success', 'Payment recorded successfully.');
    }

    public function payablesReport()
    {
        $suppliers = Supplier::withSum('tickets as total_owed', 'supplier_due')
            ->having('total_owed', '>', 0)
            ->orderByDesc('total_owed')
            ->get();

        $totalPayables = $suppliers->sum('total_owed');

        return view('suppliers.payables-report', compact('suppliers', 'totalPayables'));
    }
}
