<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\RestaurantTable;
use Illuminate\Http\Request;

class ReceptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $restaurant = auth()->user()->restaurant;

        $newOrders = Order::where('restaurant_id', $restaurant->id)
            ->where('status', 'pending')
            ->with('table', 'items')
            ->oldest()
            ->get();

        $pendingPayments = Payment::where('restaurant_id', $restaurant->id)
            ->where('status', 'pending')
            ->with('order.table', 'receivedBy')
            ->oldest()
            ->get();

        // "Unpaid" means the confirmed payments so far don't cover the total yet -
        // this correctly keeps partially-paid (split) bills visible until fully settled.
        $unpaidOrders = Order::where('restaurant_id', $restaurant->id)
            ->where('status', 'served')
            ->with('table', 'items')
            ->withSum(['payments as paid_amount' => fn($q) => $q->where('status', 'confirmed')], 'amount')
            ->get()
            ->filter(fn($order) => (float) $order->total > (float) ($order->paid_amount ?? 0))
            ->values();

        $stats = [
            'newOrders' => $newOrders->count(),
            'pendingPayments' => $pendingPayments->count(),
            'todayRevenue' => Payment::where('restaurant_id', $restaurant->id)
                ->where('status', 'confirmed')
                ->whereDate('created_at', today())->sum('amount'),
            'todayOrders' => Order::where('restaurant_id', $restaurant->id)
                ->whereDate('created_at', today())->count(),
        ];

        return view('dashboard.reception', compact('newOrders', 'pendingPayments', 'unpaidOrders', 'stats', 'restaurant'));
    }

    public function acceptOrder(Order $order)
    {
        if ($order->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $order->update(['status' => 'accepted', 'accepted_at' => now()]);

        return redirect()->route('reception.index')->with('success', 'Order ' . $order->order_number . ' accepted and sent to kitchen.');
    }

    public function rejectOrder(Order $order)
    {
        if ($order->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $order->update(['status' => 'cancelled']);

        if ($order->table_id) {
            $hasOtherActive = Order::where('table_id', $order->table_id)
                ->whereNotIn('status', ['completed', 'cancelled'])
                ->where('id', '!=', $order->id)
                ->exists();
            if (!$hasOtherActive) {
                RestaurantTable::where('id', $order->table_id)->update(['status' => 'available']);
            }
        }

        return redirect()->route('reception.index')->with('success', 'Order ' . $order->order_number . ' rejected.');
    }

    public function confirmPayment(Payment $payment)
    {
        if ($payment->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $payment->update(['status' => 'confirmed']);

        $order = $payment->order;
        $totalPaid = $order->payments()->where('status', 'confirmed')->sum('amount');

        if ($totalPaid >= $order->total) {
            $order->update(['status' => 'completed', 'completed_at' => now()]);
            if ($order->table_id) {
                RestaurantTable::where('id', $order->table_id)->update(['status' => 'available']);
            }
        }

        return redirect()->route('reception.index')->with('success', 'Payment confirmed for ' . $order->order_number . '.');
    }

    public function recordPayment(Order $order, Request $request)
    {
        if ($order->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:cash,mobile_money,card,bank',
            'amount' => 'required|numeric|min:0.01',
        ]);

        $alreadyPaid = (float) $order->payments()->where('status', 'confirmed')->sum('amount');
        $remaining = round((float) $order->total - $alreadyPaid, 2);

        // Split-payment rule: never allow a contribution that overpays the bill.
        if ($validated['amount'] > $remaining + 0.01) {
            return back()->withErrors([
                'amount' => 'That amount exceeds the remaining balance of ' . number_format($remaining) . '.',
            ]);
        }

        Payment::create([
            'order_id' => $order->id,
            'restaurant_id' => $order->restaurant_id,
            'payment_method' => $validated['payment_method'],
            'amount' => $validated['amount'],
            'status' => 'confirmed',
            'received_by' => auth()->id(),
        ]);

        $totalPaid = $alreadyPaid + $validated['amount'];

        if ($totalPaid >= $order->total - 0.01) {
            $order->update(['status' => 'completed', 'completed_at' => now()]);
            if ($order->table_id) {
                RestaurantTable::where('id', $order->table_id)->update(['status' => 'available']);
            }
            return redirect()->route('reception.index')->with('success', 'Payment recorded. Order ' . $order->order_number . ' fully paid & completed.');
        }

        return redirect()->route('reception.index')->with('success', 'Partial payment recorded for ' . $order->order_number . '. Remaining: ' . number_format($order->total - $totalPaid));
    }

    public function receipt(Order $order)
    {
        if ($order->restaurant_id !== auth()->user()->restaurant->id) {
            abort(403);
        }

        $order->load('restaurant', 'table', 'items', 'payments');

        return view('dashboard.receipt', compact('order'));
    }
}
