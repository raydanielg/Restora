<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->restaurant) {
            return redirect()->route('home');
        }

        return view('onboarding.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:restaurant,cafe,bar,fast_food',
            'description' => 'nullable|string|max:1000',
            'phone' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'currency' => 'nullable|string|max:10',
            'tax_rate' => 'nullable|numeric|min:0|max:100',
            'service_charge' => 'nullable|numeric|min:0|max:100',
            'tin_number' => 'nullable|string|max:255',
            'opening_hours' => 'nullable|array',
            'payment_methods' => 'nullable|array',
        ]);

        $restaurant = Restaurant::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? null,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'address' => $validated['address'],
            'location' => $validated['location'] ?? null,
            'currency' => $validated['currency'] ?? 'TZS',
            'tax_rate' => $validated['tax_rate'] ?? 10.00,
            'service_charge' => $validated['service_charge'] ?? 0.00,
            'tin_number' => $validated['tin_number'] ?? null,
            'opening_hours' => $validated['opening_hours'] ?? null,
            'payment_methods' => $validated['payment_methods'] ?? ['cash'],
            'status' => 'approved',
        ]);

        auth()->user()->update(['restaurant_id' => $restaurant->id]);

        return response()->json(['success' => true, 'redirect' => route('home')]);
    }
}
