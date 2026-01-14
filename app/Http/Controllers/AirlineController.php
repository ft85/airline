<?php

namespace App\Http\Controllers;

use App\Models\Airline;
use Illuminate\Http\Request;

class AirlineController extends Controller
{
    public function index()
    {
        $airlines = Airline::orderBy('name')->paginate(20);
        return view('airlines.index', compact('airlines'));
    }

    public function create()
    {
        return view('airlines.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:2|unique:airlines',
            'commission_percentage' => 'required|numeric|min:0|max:100',
        ]);

        Airline::create($request->all());

        return redirect()->route('airlines.index')
            ->with('success', 'Airline created successfully.');
    }

    public function show(Airline $airline)
    {
        $airline->load(['tickets', 'commissions']);
        return view('airlines.show', compact('airline'));
    }

    public function edit(Airline $airline)
    {
        return view('airlines.edit', compact('airline'));
    }

    public function update(Request $request, Airline $airline)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:2|unique:airlines,code,' . $airline->id,
            'commission_percentage' => 'required|numeric|min:0|max:100',
            'is_active' => 'boolean',
        ]);

        $airline->update($request->all());

        return redirect()->route('airlines.index')
            ->with('success', 'Airline updated successfully.');
    }

    public function destroy(Airline $airline)
    {
        $airline->delete();
        return redirect()->route('airlines.index')
            ->with('success', 'Airline deleted successfully.');
    }
}
