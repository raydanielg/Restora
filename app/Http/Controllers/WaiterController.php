<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class WaiterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;

        $readyOrders = Order::where('restaurant_id', $restaurant->id)
            ->where('status', 'ready')
            ->with('table', 'items')
            ->orderBy('updated_at')
            ->get();

        $activeOrders = Order::where('restaurant_id', $restaurant->id)
            ->whereIn('status', ['pending', 'accepted', 'preparing', 'served'])
            ->with('table', 'items')
            ->latest()
            ->get();

        $tables = RestaurantTable::where('restaurant_id', $restaurant->id)
            ->orderBy('table_number')
            ->get();

        $stats = [
            'ready' => $readyOrders->count(),
            'active' => $activeOrders->count(),
            'servedToday' => Order::where('restaurant_id', $restaurant->id)
                ->where('waiter_id', auth()->id())
                ->whereIn('status', ['served', 'completed'])
                ->whereDate('updated_at', today())->count(),
            'occupiedTables' => $tables->where('status', 'occupied')->count(),
        ];

        return view('dashboard.waiter', compact('readyOrders', 'activeOrders', 'tables', 'stats', 'restaurant'));
    }

    public function serve(Order $order)
    {
        if ($order->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $order->update(['status' => 'served', 'waiter_id' => $order->waiter_id ?? auth()->id()]);

        return redirect()->route('waiter.index')->with('success', 'Order ' . $order->order_number . ' served.');
    }

    public function collectCash(Order $order, Request $request)
    {
        if ($order->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        Payment::create([
            'order_id' => $order->id,
            'restaurant_id' => $order->restaurant_id,
            'payment_method' => 'cash',
            'amount' => $order->total,
            'status' => 'pending',
            'received_by' => auth()->id(),
            'notes' => 'Cash collected by waiter, pending reception confirmation',
        ]);

        return redirect()->route('waiter.index')->with('success', 'Cash collected for ' . $order->order_number . '. Submit to reception for confirmation.');
    }
}
