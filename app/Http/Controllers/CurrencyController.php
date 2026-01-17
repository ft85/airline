<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {
        $currencies = Currency::orderBy('code')->get();
        return view('currencies.index', compact('currencies'));
    }

    public function create()
    {
        return view('currencies.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies,code',
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0.000001',
            'is_base' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $validated['is_base'] = $request->has('is_base');
        $validated['is_active'] = $request->has('is_active') || true;

        if ($validated['is_base']) {
            Currency::where('is_base', true)->update(['is_base' => false]);
            $validated['exchange_rate'] = 1;
        }

        Currency::create($validated);

        return redirect()->route('currencies.index')->with('success', 'Currency created successfully.');
    }

    public function edit(Currency $currency)
    {
        return view('currencies.edit', compact('currency'));
    }

    public function update(Request $request, Currency $currency)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:3|unique:currencies,code,' . $currency->id,
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:10',
            'exchange_rate' => 'required|numeric|min:0.000001',
            'is_base' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $validated['is_base'] = $request->has('is_base');
        $validated['is_active'] = $request->has('is_active');

        if ($validated['is_base'] && !$currency->is_base) {
            Currency::where('is_base', true)->update(['is_base' => false]);
            $validated['exchange_rate'] = 1;
        }

        $currency->update($validated);

        return redirect()->route('currencies.index')->with('success', 'Currency updated successfully.');
    }

    public function destroy(Currency $currency)
    {
        if ($currency->is_base) {
            return redirect()->route('currencies.index')->with('error', 'Cannot delete base currency.');
        }

        $currency->delete();
        return redirect()->route('currencies.index')->with('success', 'Currency deleted successfully.');
    }
}
