<?php

namespace App\Http\Controllers;

use App\Models\ExpenseCategory;
use Illuminate\Http\Request;

class ExpenseCategoryController extends Controller
{
    public function index()
    {
        $categories = ExpenseCategory::withSum('expenses as total_expenses', 'amount_base')
            ->orderBy('name')
            ->get();
        return view('expense-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('expense-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active') || true;

        ExpenseCategory::create($validated);

        return redirect()->route('expense-categories.index')->with('success', 'Category created successfully.');
    }

    public function edit(ExpenseCategory $expenseCategory)
    {
        return view('expense-categories.edit', compact('expenseCategory'));
    }

    public function update(Request $request, ExpenseCategory $expenseCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:7',
            'is_active' => 'boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $expenseCategory->update($validated);

        return redirect()->route('expense-categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(ExpenseCategory $expenseCategory)
    {
        if ($expenseCategory->expenses()->count() > 0) {
            return redirect()->route('expense-categories.index')
                ->with('error', 'Cannot delete category with existing expenses.');
        }

        $expenseCategory->delete();
        return redirect()->route('expense-categories.index')->with('success', 'Category deleted successfully.');
    }
}
