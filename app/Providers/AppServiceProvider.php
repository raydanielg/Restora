<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Powers the notification bell in the dashboard layout with real,
        // role-relevant alerts (new orders / ready meals / pending cash),
        // instead of the previous static red dot.
        View::composer('layouts.dashboard', function ($view) {
            $view->with('liveNotifications', $this->buildLiveNotifications());
        });
    }

    private function buildLiveNotifications(): array
    {
        $user = auth()->user();
        if (!$user || !$user->restaurant) {
            return [];
        }

        $restaurantId = $user->restaurant->id;
        $items = [];

        if (in_array($user->role, ['owner', 'manager', 'reception'])) {
            Order::where('restaurant_id', $restaurantId)
                ->where('status', 'pending')
                ->with('table')
                ->latest()
                ->limit(5)
                ->get()
                ->each(function ($order) use (&$items) {
                    $items[] = [
                        'icon' => 'new',
                        'text' => 'New order ' . $order->order_number . ' from ' . ($order->table?->table_number ?? 'Takeaway'),
                        'time' => $order->created_at->diffForHumans(),
                        'url' => route('reception.index'),
                    ];
                });

            Payment::where('restaurant_id', $restaurantId)
                ->where('status', 'pending')
                ->with('order')
                ->latest()
                ->limit(5)
                ->get()
                ->each(function ($payment) use (&$items) {
                    $items[] = [
                        'icon' => 'cash',
                        'text' => 'Cash handover pending for ' . ($payment->order?->order_number ?? 'order'),
                        'time' => $payment->created_at->diffForHumans(),
                        'url' => route('reception.index'),
                    ];
                });
        }

        if (in_array($user->role, ['owner', 'manager', 'chef'])) {
            Order::where('restaurant_id', $restaurantId)
                ->whereIn('status', ['accepted', 'preparing'])
                ->latest()
                ->limit(5)
                ->get()
                ->each(function ($order) use (&$items) {
                    $items[] = [
                        'icon' => 'kitchen',
                        'text' => 'Order ' . $order->order_number . ' waiting in kitchen',
                        'time' => $order->created_at->diffForHumans(),
                        'url' => route('kitchen.index'),
                    ];
                });
        }

        if (in_array($user->role, ['owner', 'manager', 'waiter'])) {
            Order::where('restaurant_id', $restaurantId)
                ->where('status', 'ready')
                ->with('table')
                ->latest()
                ->limit(5)
                ->get()
                ->each(function ($order) use (&$items) {
                    $items[] = [
                        'icon' => 'ready',
                        'text' => 'Order ' . $order->order_number . ' ready to serve at ' . ($order->table?->table_number ?? 'Takeaway'),
                        'time' => $order->created_at->diffForHumans(),
                        'url' => route('waiter.index'),
                    ];
                });
        }

        return array_slice($items, 0, 8);
    }
}
