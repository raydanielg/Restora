<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\Category;
use App\Models\MenuItem;
use App\Models\RestaurantTable;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Restaurant Owner',
            'email' => 'owner@restora.test',
            'phone' => '0712 345 678',
            'password' => bcrypt('password'),
            'role' => 'owner',
        ]);

        $restaurant = Restaurant::create([
            'user_id' => $user->id,
            'name' => 'The Grand Restaurant',
            'type' => 'restaurant',
            'description' => 'A fine dining restaurant serving the best cuisine in town.',
            'phone' => '0712 345 678',
            'email' => 'info@grandrestaurant.com',
            'address' => '123 Main Street, Dar es Salaam',
            'location' => 'Dar es Salaam',
            'currency' => 'TZS',
            'tax_rate' => 10.00,
            'service_charge' => 5.00,
            'status' => 'approved',
            'tin_number' => '123-456-789',
        ]);

        $user->update(['restaurant_id' => $restaurant->id]);

        // Categories
        $breakfast = Category::create(['restaurant_id' => $restaurant->id, 'name' => 'Breakfast', 'sort_order' => 1]);
        $lunch = Category::create(['restaurant_id' => $restaurant->id, 'name' => 'Lunch', 'sort_order' => 2]);
        $dinner = Category::create(['restaurant_id' => $restaurant->id, 'name' => 'Dinner', 'sort_order' => 3]);
        $drinks = Category::create(['restaurant_id' => $restaurant->id, 'name' => 'Drinks', 'sort_order' => 4]);
        $desserts = Category::create(['restaurant_id' => $restaurant->id, 'name' => 'Desserts', 'sort_order' => 5]);

        // Menu Items
        $items = [
            [$breakfast->id, 'English Breakfast', 'Eggs, bacon, sausage, beans, toast', 15000],
            [$breakfast->id, 'Continental Breakfast', 'Croissant, jam, butter, coffee', 12000],
            [$breakfast->id, 'Pancakes', 'Fluffy pancakes with maple syrup', 10000],
            [$lunch->id, 'Beef Burger', 'Juicy beef patty with cheese and fries', 15000],
            [$lunch->id, 'Margherita Pizza', 'Classic pizza with tomato and mozzarella', 20000],
            [$lunch->id, 'Chicken Wings', 'Spicy chicken wings with dip', 12000],
            [$lunch->id, 'Caesar Salad', 'Fresh salad with Caesar dressing', 10000],
            [$lunch->id, 'Fish & Chips', 'Battered fish with crispy fries', 15000],
            [$dinner->id, 'Grilled Steak', 'Prime cut steak with vegetables', 35000],
            [$dinner->id, 'Seafood Platter', 'Mixed grill of prawns, fish, and calamari', 45000],
            [$dinner->id, 'Pasta Carbonara', 'Italian pasta with creamy sauce', 18000],
            [$drinks->id, 'Fresh Juice', 'Orange, mango, or passion fruit', 5000],
            [$drinks->id, 'Soft Drink', 'Coca-Cola, Fanta, or Sprite', 3000],
            [$drinks->id, 'Coffee', 'Espresso, cappuccino, or latte', 5000],
            [$desserts->id, 'Chocolate Cake', 'Rich chocolate cake with ice cream', 8000],
            [$desserts->id, 'Ice Cream Sundae', 'Vanilla ice cream with toppings', 7000],
        ];

        $menuItems = [];
        foreach ($items as $item) {
            $menuItems[] = MenuItem::create([
                'restaurant_id' => $restaurant->id,
                'category_id' => $item[0],
                'name' => $item[1],
                'description' => $item[2],
                'price' => $item[3],
                'preparation_time' => rand(10, 25),
            ]);
        }

        // Tables
        for ($i = 1; $i <= 12; $i++) {
            RestaurantTable::create([
                'restaurant_id' => $restaurant->id,
                'table_number' => 'Table ' . str_pad((string)$i, 2, '0', STR_PAD_LEFT),
                'section' => $i <= 8 ? 'indoor' : ($i <= 10 ? 'outdoor' : 'vip'),
                'capacity' => $i <= 6 ? 4 : ($i <= 10 ? 6 : 8),
                'qr_code' => 'RST-' . strtoupper(uniqid()),
                'status' => $i <= 6 ? 'occupied' : 'available',
            ]);
        }

        // Staff
        $staffData = [
            ['John Mwangaza', '0722 111 222', 'chef'],
            ['Sarah Kimaro', '0733 333 444', 'waiter'],
            ['David Lucas', '0744 555 666', 'reception'],
            ['Mary Thomas', '0755 777 888', 'waiter'],
        ];

        foreach ($staffData as $staff) {
            $code = str_pad((string) random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            User::create([
                'name' => $staff[0],
                'phone' => $staff[1],
                'role' => $staff[2],
                'restaurant_id' => $restaurant->id,
                'staff_code' => $code,
                'email' => strtolower(str_replace(' ', '.', $staff[0])) . '@staff.restora.app',
                'password' => bcrypt($code),
            ]);
        }

        // Sample Orders
        $tables = RestaurantTable::where('restaurant_id', $restaurant->id)->get();
        $waiters = User::where('restaurant_id', $restaurant->id)->where('role', 'waiter')->get();

        for ($i = 1; $i <= 20; $i++) {
            $table = $tables->random();
            $waiter = $waiters->random();
            $orderItems = $menuItems[array_rand($menuItems)];
            $qty = rand(1, 3);

            $subtotal = $orderItems->price * $qty;
            $tax = $subtotal * 0.10;
            $service = $subtotal * 0.05;
            $total = $subtotal + $tax + $service;

            $statuses = ['pending', 'accepted', 'preparing', 'ready', 'served', 'completed', 'completed', 'completed'];
            $status = $statuses[array_rand($statuses)];

            $order = Order::create([
                'order_number' => 'ORD-' . str_pad((string)$i, 6, '0', STR_PAD_LEFT),
                'restaurant_id' => $restaurant->id,
                'table_id' => $table->id,
                'waiter_id' => $waiter->id,
                'status' => $status,
                'order_type' => 'dine_in',
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'service_charge' => $service,
                'total' => $total,
                'accepted_at' => $status !== 'pending' ? now()->subHours(rand(1, 48)) : null,
                'completed_at' => $status === 'completed' ? now()->subHours(rand(1, 48)) : null,
                'created_at' => now()->subDays(rand(0, 13))->subHours(rand(0, 23)),
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'menu_item_id' => $orderItems->id,
                'menu_item_name' => $orderItems->name,
                'price' => $orderItems->price,
                'quantity' => $qty,
                'status' => $status === 'completed' ? 'served' : 'pending',
            ]);

            if ($status === 'completed') {
                Payment::create([
                    'order_id' => $order->id,
                    'restaurant_id' => $restaurant->id,
                    'payment_method' => ['cash', 'mobile_money', 'card'][array_rand(['cash', 'mobile_money', 'card'])],
                    'amount' => $total,
                    'status' => 'confirmed',
                    'received_by' => $waiter->id,
                    'created_at' => $order->completed_at,
                ]);
            }
        }
    }
}
