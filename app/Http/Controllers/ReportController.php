<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;

        $totalRevenue = Payment::where('restaurant_id', $restaurant->id)->where('status', 'confirmed')->sum('amount');
        $totalOrders = Order::where('restaurant_id', $restaurant->id)->count();
        $completedOrders = Order::where('restaurant_id', $restaurant->id)->where('status', 'completed')->count();
        $cancelledOrders = Order::where('restaurant_id', $restaurant->id)->where('status', 'cancelled')->count();

        $dailyRevenue = [];
        $dailyOrders = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyRevenue[] = (int) Payment::where('restaurant_id', $restaurant->id)->where('status', 'confirmed')->whereDate('created_at', $date)->sum('amount');
            $dailyOrders[] = Order::where('restaurant_id', $restaurant->id)->whereDate('created_at', $date)->count();
        }

        $topDishes = MenuItem::where('restaurant_id', $restaurant->id)
            ->withSum('orderItems as total_sold', 'quantity')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        $paymentBreakdown = [
            'cash' => Payment::where('restaurant_id', $restaurant->id)->where('status', 'confirmed')->where('payment_method', 'cash')->sum('amount'),
            'mobile_money' => Payment::where('restaurant_id', $restaurant->id)->where('status', 'confirmed')->where('payment_method', 'mobile_money')->sum('amount'),
            'card' => Payment::where('restaurant_id', $restaurant->id)->where('status', 'confirmed')->where('payment_method', 'card')->sum('amount'),
        ];

        $staffPerformance = User::where('restaurant_id', $restaurant->id)
            ->where('role', '!=', 'owner')
            ->withCount(['orders as orders_handled' => fn($q) => $q->where('status', 'completed')])
            ->get();

        return view('dashboard.reports', compact(
            'totalRevenue', 'totalOrders', 'completedOrders', 'cancelledOrders',
            'dailyRevenue', 'dailyOrders', 'topDishes', 'paymentBreakdown', 'staffPerformance', 'restaurant'
        ));
    }
}
