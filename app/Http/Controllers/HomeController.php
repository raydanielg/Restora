<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Models\Order;
use App\Models\MenuItem;
use App\Models\RestaurantTable;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;

        if (!$restaurant) {
            return redirect()->route('onboarding.index');
        }

        $today = now()->startOfDay();

        $stats = [
            'totalRevenue' => Payment::where('restaurant_id', $restaurant->id)->where('status', 'confirmed')->sum('amount'),
            'todayRevenue' => Payment::where('restaurant_id', $restaurant->id)->where('status', 'confirmed')->where('created_at', '>=', $today)->sum('amount'),
            'totalOrders' => Order::where('restaurant_id', $restaurant->id)->count(),
            'todayOrders' => Order::where('restaurant_id', $restaurant->id)->where('created_at', '>=', $today)->count(),
            'activeTables' => RestaurantTable::where('restaurant_id', $restaurant->id)->where('status', 'occupied')->count(),
            'totalTables' => RestaurantTable::where('restaurant_id', $restaurant->id)->count(),
            'totalMenuItems' => MenuItem::where('restaurant_id', $restaurant->id)->count(),
            'totalStaff' => User::where('restaurant_id', $restaurant->id)->where('role', '!=', 'owner')->count(),
            'pendingOrders' => Order::where('restaurant_id', $restaurant->id)->whereIn('status', ['pending', 'accepted', 'preparing'])->count(),
            'completedOrders' => Order::where('restaurant_id', $restaurant->id)->where('status', 'completed')->count(),
        ];

        $recentOrders = Order::where('restaurant_id', $restaurant->id)
            ->with('table', 'items')
            ->latest()
            ->limit(6)
            ->get();

        $topDishes = MenuItem::where('restaurant_id', $restaurant->id)
            ->withSum('orderItems as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        $dailyRevenue = [];
        for ($i = 13; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $rev = Payment::where('restaurant_id', $restaurant->id)
                ->where('status', 'confirmed')
                ->whereDate('created_at', $date)
                ->sum('amount');
            $dailyRevenue[] = (int) $rev;
        }

        $staffOnDuty = User::where('restaurant_id', $restaurant->id)
            ->where('role', '!=', 'owner')
            ->limit(4)
            ->get();

        return view('home', compact('stats', 'recentOrders', 'topDishes', 'dailyRevenue', 'staffOnDuty', 'restaurant'));
    }
}
