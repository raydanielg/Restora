<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;
        $orders = Order::where('restaurant_id', $restaurant->id)
            ->with('table', 'waiter', 'items')
            ->latest()
            ->paginate(15);

        return view('dashboard.orders', compact('orders', 'restaurant'));
    }

    public function create()
    {
        $restaurant = auth()->user()->restaurant;
        $categories = \App\Models\Category::where('restaurant_id', $restaurant->id)
            ->with('menuItems')
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        $tables = RestaurantTable::where('restaurant_id', $restaurant->id)
            ->where('status', '!=', 'occupied')
            ->orderBy('table_number')
            ->get();

        return view('dashboard.orders-create', compact('categories', 'tables', 'restaurant'));
    }

    public function store(Request $request)
    {
        $restaurant = auth()->user()->restaurant;

        $validated = $request->validate([
            'table_id' => 'nullable|exists:restaurant_tables,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'order_type' => 'required|in:dine_in,takeaway,delivery',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.special_instructions' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $subtotal = 0;
        $orderItems = [];

        foreach ($validated['items'] as $item) {
            $menuItem = MenuItem::find($item['menu_item_id']);
            if (!$menuItem || !$menuItem->is_available) {
                return back()->withErrors("Item {$menuItem?->name} is not available.");
            }
            $lineTotal = $menuItem->price * $item['quantity'];
            $subtotal += $lineTotal;
            $orderItems[] = [
                'menu_item_id' => $menuItem->id,
                'menu_item_name' => $menuItem->name,
                'price' => $menuItem->price,
                'quantity' => $item['quantity'],
                'special_instructions' => $item['special_instructions'] ?? null,
            ];
        }

        $taxAmount = $subtotal * ($restaurant->tax_rate / 100);
        $serviceCharge = $subtotal * ($restaurant->service_charge / 100);
        $total = $subtotal + $taxAmount + $serviceCharge;

        $order = Order::create([
            'order_number' => Order::generateOrderNumber(),
            'restaurant_id' => $restaurant->id,
            'table_id' => $validated['table_id'] ?? null,
            'waiter_id' => auth()->id(),
            'customer_name' => $validated['customer_name'] ?? null,
            'customer_phone' => $validated['customer_phone'] ?? null,
            'order_type' => $validated['order_type'],
            'status' => 'pending',
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'service_charge' => $serviceCharge,
            'total' => $total,
            'notes' => $validated['notes'] ?? null,
        ]);

        foreach ($orderItems as $item) {
            $item['order_id'] = $order->id;
            OrderItem::create($item);
        }

        if ($validated['table_id'] ?? null) {
            RestaurantTable::where('id', $validated['table_id'])->update(['status' => 'occupied']);
        }

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        if ($order->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $order->load('table', 'waiter', 'items.menuItem', 'payments');

        return view('dashboard.orders-show', compact('order'));
    }

    public function updateStatus(Order $order, Request $request)
    {
        if ($order->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $validated = $request->validate([
            'status' => 'required|in:pending,accepted,preparing,ready,served,completed,cancelled',
        ]);

        $order->update([
            'status' => $validated['status'],
            'accepted_at' => $validated['status'] !== 'pending' && !$order->accepted_at ? now() : $order->accepted_at,
            'completed_at' => $validated['status'] === 'completed' ? now() : $order->completed_at,
        ]);

        if ($validated['status'] === 'completed' && $order->table_id) {
            RestaurantTable::where('id', $order->table_id)->update(['status' => 'available']);
        }
        if ($validated['status'] === 'cancelled' && $order->table_id) {
            RestaurantTable::where('id', $order->table_id)->update(['status' => 'available']);
        }

        return redirect()->route('orders.index')->with('success', 'Order status updated.');
    }
}
