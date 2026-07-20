@extends('layouts.dashboard')

@section('title', 'Order Details - Restora')
@section('page_title', 'Order ' . $order->order_number)

@section('content')
<div class="mb-6">
    <a href="{{ route('orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Orders
    </a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    {{-- Order Items --}}
    <div class="lg:col-span-2 bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="text-sm font-bold text-gray-900">Order Items</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach($order->items as $item)
            <div class="flex items-center gap-4 px-5 py-3">
                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0 text-xs font-bold text-gray-500">
                    {{ strtoupper(substr($item->menu_item_name, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $item->menu_item_name }}</p>
                    @if($item->special_instructions)
                    <p class="text-xs text-gray-400">{{ $item->special_instructions }}</p>
                    @endif
                </div>
                <div class="text-right shrink-0">
                    <p class="text-xs text-gray-500">{{ $item->quantity }} x TSh {{ number_format($item->price) }}</p>
                    <p class="text-sm font-bold text-gray-900">TSh {{ number_format($item->price * $item->quantity) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="px-5 py-4 border-t bg-gray-50/50 space-y-1">
            <div class="flex justify-between text-sm"><span class="text-gray-500">Subtotal</span><span class="font-medium text-gray-900">TSh {{ number_format($order->subtotal) }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Tax</span><span class="font-medium text-gray-900">TSh {{ number_format($order->tax_amount) }}</span></div>
            <div class="flex justify-between text-sm"><span class="text-gray-500">Service Charge</span><span class="font-medium text-gray-900">TSh {{ number_format($order->service_charge) }}</span></div>
            <div class="flex justify-between text-base font-bold pt-1"><span class="text-gray-900">Total</span><span class="text-emerald-600">TSh {{ number_format($order->total) }}</span></div>
        </div>
    </div>

    {{-- Order Info --}}
    <div class="space-y-4">
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Order Info</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Order #</span><span class="font-mono font-medium text-gray-900">{{ $order->order_number }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Type</span><span class="font-medium text-gray-900">{{ ucfirst(str_replace('_', ' ', $order->order_type)) }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Table</span><span class="font-medium text-gray-900">{{ $order->table?->table_number ?? 'N/A' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Waiter</span><span class="font-medium text-gray-900">{{ $order->waiter?->name ?? 'N/A' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Customer</span><span class="font-medium text-gray-900">{{ $order->customer_name ?? 'Walk-in' }}</span></div>
                <div class="flex justify-between"><span class="text-gray-500">Date</span><span class="font-medium text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}</span></div>
                <div class="flex justify-between items-center"><span class="text-gray-500">Status</span>
                    <form action="{{ route('orders.status', $order) }}" method="POST">
                        @csrf @method('PATCH')
                        <select name="status" onchange="this.form.submit()" class="text-xs border border-gray-200 rounded-md px-2 py-1 outline-none focus:border-emerald-500">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                            <option value="served" {{ $order->status === 'served' ? 'selected' : '' }}>Served</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        @if($order->payments->isNotEmpty())
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-3">Payments</h3>
            <div class="space-y-2">
                @foreach($order->payments as $payment)
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                    <span class="font-medium {{ $payment->status === 'confirmed' ? 'text-emerald-600' : 'text-amber-600' }}">TSh {{ number_format($payment->amount) }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($order->notes)
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-2">Notes</h3>
            <p class="text-sm text-gray-600">{{ $order->notes }}</p>
        </div>
        @endif
    </div>
</div>
@endsection
