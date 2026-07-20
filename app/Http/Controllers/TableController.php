<?php

namespace App\Http\Controllers;

use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        $tables = RestaurantTable::where('restaurant_id', $restaurant->id)
            ->with('activeOrder')
            ->orderBy('table_number')
            ->get();

        return view('dashboard.tables', compact('tables', 'restaurant'));
    }

    public function store(Request $request)
    {
        $restaurant = auth()->user()->restaurant;

        $validated = $request->validate([
            'table_number' => 'required|string|max:255',
            'section' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
        ]);

        RestaurantTable::create([
            'restaurant_id' => $restaurant->id,
            'table_number' => $validated['table_number'],
            'section' => $validated['section'] ?? 'indoor',
            'capacity' => $validated['capacity'] ?? 4,
            'qr_code' => 'RST-' . strtoupper(uniqid()),
        ]);

        return redirect()->route('tables.index')->with('success', 'Table created successfully.');
    }

    public function updateStatus(RestaurantTable $table, Request $request)
    {
        if ($table->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:available,occupied,reserved',
        ]);

        $table->update(['status' => $validated['status']]);

        return redirect()->route('tables.index')->with('success', 'Table status updated.');
    }

    public function destroy(RestaurantTable $table)
    {
        if ($table->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Table deleted.');
    }
}
