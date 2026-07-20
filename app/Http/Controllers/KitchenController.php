<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class KitchenController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;

        $orders = Order::where('restaurant_id', $restaurant->id)
            ->whereIn('status', ['accepted', 'preparing'])
            ->with('table', 'items')
            ->orderBy('accepted_at')
            ->get();

        $readyOrders = Order::where('restaurant_id', $restaurant->id)
            ->where('status', 'ready')
            ->with('table', 'items')
            ->latest()
            ->limit(10)
            ->get();

        $stats = [
            'queue' => $orders->count(),
            'preparing' => $orders->where('status', 'preparing')->count(),
            'readyToday' => Order::where('restaurant_id', $restaurant->id)
                ->whereIn('status', ['ready', 'served', 'completed'])
                ->whereDate('updated_at', today())->count(),
        ];

        return view('dashboard.kitchen', compact('orders', 'readyOrders', 'stats', 'restaurant'));
    }

    public function updateStatus(Order $order, Request $request)
    {
        if ($order->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:preparing,ready',
        ]);

        $order->update(['status' => $validated['status']]);

        return redirect()->route('kitchen.index')->with('success', 'Order ' . $order->order_number . ' marked as ' . $validated['status'] . '.');
    }
}
