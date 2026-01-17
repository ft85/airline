<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\Currency;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with(['category', 'currency', 'user']);

        if ($request->filled('date_from')) {
            $query->whereDate('expense_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('expense_date', '<=', $request->date_to);
        }
        if ($request->filled('category')) {
            $query->where('expense_category_id', $request->category);
        }
        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $expenses = $query->orderBy('expense_date', 'desc')->paginate(20);
        $categories = ExpenseCategory::where('is_active', true)->get();
        
        $totalExpenses = $query->sum('amount_base');

        return view('expenses.index', compact('expenses', 'categories', 'totalExpenses'));
    }

    public function create()
    {
        $categories = ExpenseCategory::where('is_active', true)->get();
        $currencies = Currency::where('is_active', true)->get();
        return view('expenses.create', compact('categories', 'currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'currency_id' => 'required|exists:currencies,id',
            'expense_date' => 'required|date',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,credit_card,check',
            'reference' => 'nullable|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $validated['user_id'] = auth()->id();
        
        $currency = Currency::find($validated['currency_id']);
        $validated['amount_base'] = $currency->convertToBase($validated['amount']);

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense recorded successfully.');
    }

    public function show(Expense $expense)
    {
        $expense->load(['category', 'currency', 'user']);
        return view('expenses.show', compact('expense'));
    }

    public function edit(Expense $expense)
    {
        $categories = ExpenseCategory::where('is_active', true)->get();
        $currencies = Currency::where('is_active', true)->get();
        return view('expenses.edit', compact('expense', 'categories', 'currencies'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'expense_category_id' => 'required|exists:expense_categories,id',
            'currency_id' => 'required|exists:currencies,id',
            'expense_date' => 'required|date',
            'description' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:cash,bank_transfer,mobile_money,credit_card,check',
            'reference' => 'nullable|string|max:255',
            'vendor' => 'nullable|string|max:255',
            'notes' => 'nullable|string'
        ]);

        $currency = Currency::find($validated['currency_id']);
        $validated['amount_base'] = $currency->convertToBase($validated['amount']);

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Expense updated successfully.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route('expenses.index')->with('success', 'Expense deleted successfully.');
    }

    public function dailyReport(Request $request)
    {
        $date = $request->get('date', now()->toDateString());
        
        $expenses = Expense::with(['category', 'currency'])
            ->whereDate('expense_date', $date)
            ->orderBy('created_at', 'desc')
            ->get();

        $byCategory = $expenses->groupBy('expense_category_id')->map(function ($items) {
            return [
                'category' => $items->first()->category,
                'total' => $items->sum('amount_base'),
                'count' => $items->count()
            ];
        });

        $byPaymentMethod = $expenses->groupBy('payment_method')->map(function ($items) {
            return $items->sum('amount_base');
        });

        $totalExpenses = $expenses->sum('amount_base');

        return view('expenses.daily-report', compact('expenses', 'byCategory', 'byPaymentMethod', 'totalExpenses', 'date'));
    }
}
