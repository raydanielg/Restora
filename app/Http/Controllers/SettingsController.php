<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        return view('dashboard.settings', compact('restaurant'));
    }

    public function update(Request $request)
    {
        $restaurant = auth()->user()->restaurant;

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'phone' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'service_charge' => 'nullable|numeric|min:0|max:100',
            'tin_number' => 'nullable|string|max:255',
        ]);

        $restaurant->update($validated);

        return redirect()->route('settings.index')->with('success', 'Restaurant settings updated successfully.');
    }
}
