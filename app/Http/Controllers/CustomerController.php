<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\RestaurantTable;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // Public restaurant menu via slug: /r/{slug}
    public function restaurant(string $slug)
    {
        $restaurant = Restaurant::where('slug', $slug)->where('status', 'approved')->firstOrFail();
        $categories = Category::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->with(['menuItems' => fn($q) => $q->where('is_available', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('customer.menu', compact('restaurant', 'categories'))->with('table', null);
    }

    // Table QR ordering: /table/{qr_code}
    public function table(string $qrCode)
    {
        $table = RestaurantTable::where('qr_code', $qrCode)->firstOrFail();
        $restaurant = $table->restaurant;

        if ($restaurant->status !== 'approved') {
            abort(404);
        }

        $categories = Category::where('restaurant_id', $restaurant->id)
            ->where('is_active', true)
            ->with(['menuItems' => fn($q) => $q->where('is_available', true)->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        return view('customer.menu', compact('restaurant', 'categories', 'table'));
    }

    // Place order from customer (AJAX)
    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'table_id' => 'nullable|exists:restaurant_tables,id',
            'customer_name' => 'nullable|string|max:255',
            'customer_phone' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.menu_item_id' => 'required|exists:menu_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.special_instructions' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $restaurant = Restaurant::findOrFail($validated['restaurant_id']);

        $subtotal = 0;
        $orderItems = [];

        foreach ($validated['items'] as $item) {
            $menuItem = MenuItem::where('id', $item['menu_item_id'])
                ->where('restaurant_id', $restaurant->id)
                ->where('is_available', true)
                ->first();

            if (!$menuItem) {
                return response()->json(['success' => false, 'message' => 'One or more items are no longer available.'], 422);
            }

            $subtotal += $menuItem->price * $item['quantity'];
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
            'customer_name' => $validated['customer_name'] ?? 'Guest',
            'customer_phone' => $validated['customer_phone'] ?? null,
            'order_type' => 'dine_in',
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

        // Track customer orders in session
        $orderIds = session()->get('customer_orders', []);
        $orderIds[] = $order->id;
        session()->put('customer_orders', $orderIds);

        return response()->json([
            'success' => true,
            'order_number' => $order->order_number,
            'redirect' => route('customer.track', $order->order_number),
        ]);
    }

    // Track order status: /order/{order_number}
    public function track(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)
            ->with('restaurant', 'table', 'items')
            ->firstOrFail();

        return view('customer.track', compact('order'));
    }

    // Live order status (AJAX polling)
    public function status(string $orderNumber)
    {
        $order = Order::where('order_number', $orderNumber)->firstOrFail();

        return response()->json([
            'status' => $order->status,
            'updated_at' => $order->updated_at->diffForHumans(),
        ]);
    }
}
