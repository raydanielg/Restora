@extends('layouts.dashboard')

@section('title', 'Reception - Restora')
@section('page_title', 'Reception Dashboard')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
    <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-xl border border-red-400 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-red-100">New Orders</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['newOrders'] }}</p>
    </div>
    <div class="bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl border border-amber-300 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-amber-50">Pending Payments</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['pendingPayments'] }}</p>
    </div>
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl border border-emerald-500 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-emerald-100">Today's Revenue</span>
        <p class="text-xl sm:text-2xl font-bold mt-1">TSh {{ number_format($stats['todayRevenue']) }}</p>
    </div>
    <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl border border-sky-400 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-sky-100">Today's Orders</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['todayOrders'] }}</p>
    </div>
</div>

{{-- New Orders (Priority) --}}
@if($newOrders->isNotEmpty())
<h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
    <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
    New Orders — Action Required
</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    @foreach($newOrders as $order)
    <div class="bg-white rounded-xl border-2 border-red-200 overflow-hidden">
        <div class="px-4 py-3 bg-red-50 flex items-center justify-between">
            <div>
                <p class="text-sm font-extrabold text-gray-900">{{ $order->table?->table_number ?? 'Takeaway' }}</p>
                <p class="text-[10px] font-mono text-gray-500">{{ $order->order_number }} &middot; {{ $order->created_at->diffForHumans() }}</p>
            </div>
            <p class="text-sm font-extrabold text-gray-900">TSh {{ number_format($order->total) }}</p>
        </div>
        <div class="p-4 space-y-1">
            @foreach($order->items as $item)
            <p class="text-sm text-gray-800">{{ $item->quantity }}x {{ $item->menu_item_name }}</p>
            @endforeach
            @if($order->customer_name && $order->customer_name !== 'Guest')
            <p class="text-xs text-gray-400 pt-1">Customer: {{ $order->customer_name }}</p>
            @endif
        </div>
        <div class="p-3 border-t flex gap-2">
            <form data-ajax action="{{ route('reception.accept', $order) }}" method="POST" class="flex-1">
                @csrf @method('PATCH')
                <button type="submit" class="w-full py-2.5 text-sm font-extrabold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Accept</button>
            </form>
            <form data-ajax data-confirm="Reject order?" data-confirm-text="Order {{ $order->order_number }} will be cancelled." action="{{ route('reception.reject', $order) }}" method="POST" class="flex-1">
                @csrf @method('PATCH')
                <button type="submit" class="w-full py-2.5 text-sm font-extrabold border-2 border-red-300 text-red-600 rounded-lg hover:bg-red-50 transition-colors">Reject</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Pending Cash Confirmations --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="text-sm font-bold text-gray-900">Waiter Cash Handover</h3>
            <p class="text-xs text-gray-400">Confirm cash received from waiters</p>
        </div>
        <div class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
            @forelse($pendingPayments as $payment)
            <div class="flex items-center gap-3 px-5 py-3">
                <div class="w-9 h-9 rounded-full bg-gold-100 text-gold-700 flex items-center justify-center font-bold text-xs shrink-0">
                    {{ strtoupper(substr($payment->receivedBy?->name ?? 'W', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $payment->order->order_number }} &middot; {{ $payment->order->table?->table_number ?? 'Takeaway' }}</p>
                    <p class="text-xs text-gray-400">From: {{ $payment->receivedBy?->name ?? 'Unknown' }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm font-extrabold text-gray-900">TSh {{ number_format($payment->amount) }}</p>
                    <form data-ajax action="{{ route('reception.payment.confirm', $payment) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="text-[10px] font-bold text-emerald-600 hover:text-emerald-700 underline">Confirm Receipt</button>
                    </form>
                </div>
            </div>
            @empty
            <div class="px-5 py-10 text-center text-gray-400 text-sm">No pending cash confirmations</div>
            @endforelse
        </div>
    </div>

    {{-- Unpaid Served Orders --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="text-sm font-bold text-gray-900">Unpaid Bills</h3>
            <p class="text-xs text-gray-400">Served orders awaiting payment</p>
        </div>
        <div class="divide-y divide-gray-100 max-h-[400px] overflow-y-auto">
            @forelse($unpaidOrders as $order)
            @php
                $paid = (float) ($order->paid_amount ?? 0);
                $remaining = max(0, (float) $order->total - $paid);
            @endphp
            <div class="px-5 py-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center font-bold text-[10px] text-gray-600 shrink-0">
                        {{ strtoupper(substr($order->table?->table_number ?? 'TA', 0, 3)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900">{{ $order->order_number }}</p>
                        <p class="text-xs text-gray-400">{{ $order->items->count() }} items @if($paid > 0)&middot; <span class="text-amber-600 font-medium">TSh {{ number_format($paid) }} paid</span>@endif</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-sm font-extrabold text-gray-900">TSh {{ number_format($remaining) }}</p>
                        @if($paid > 0)<p class="text-[10px] text-gray-400">of TSh {{ number_format($order->total) }}</p>@endif
                    </div>
                </div>

                {{-- Split-payment helper: quickly divide the remaining balance among N guests --}}
                <div class="mt-2 flex items-center gap-1.5">
                    <span class="text-[10px] text-gray-400">Split:</span>
                    @foreach([2, 3, 4, 5] as $n)
                    <button type="button" onclick="applySplit({{ $order->id }}, {{ $remaining }}, {{ $n }})" class="text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-200 text-gray-600 hover:border-emerald-400 hover:text-emerald-700 transition-colors">/{{ $n }}</button>
                    @endforeach
                    <button type="button" onclick="applySplit({{ $order->id }}, {{ $remaining }}, 1)" class="text-[10px] font-bold px-2 py-0.5 rounded-full border border-gray-200 text-gray-600 hover:border-emerald-400 hover:text-emerald-700 transition-colors">Full</button>
                </div>

                <div class="mt-2 flex gap-2">
                    <form data-ajax action="{{ route('reception.payment.record', $order) }}" method="POST" class="flex-1 flex gap-2">
                        @csrf
                        <select name="payment_method" class="text-xs border border-gray-200 rounded-lg px-2 py-1.5 outline-none focus:border-emerald-500">
                            <option value="cash">Cash</option>
                            <option value="mobile_money">Mobile Money</option>
                            <option value="card">Card</option>
                            <option value="bank">Bank</option>
                        </select>
                        <input type="number" step="0.01" min="0.01" max="{{ $remaining }}" name="amount" id="amount-{{ $order->id }}" value="{{ $remaining }}" class="w-24 text-xs border border-gray-200 rounded-lg px-2 py-1.5 outline-none focus:border-emerald-500">
                        <button type="submit" class="flex-1 py-1.5 text-xs font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Record</button>
                    </form>
                    <a href="{{ route('reception.receipt', $order) }}" target="_blank" class="px-3 py-1.5 text-xs font-bold border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 transition-colors">Receipt</a>
                </div>
            </div>
            @empty
            <div class="px-5 py-10 text-center text-gray-400 text-sm">No unpaid bills</div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
<script>
// Split the remaining balance of an order evenly among N guests and fill the amount field.
function applySplit(orderId, remaining, n) {
    const input = document.getElementById('amount-' + orderId);
    if (!input) return;
    const share = n > 1 ? Math.ceil((remaining / n) * 100) / 100 : remaining;
    input.value = share;
    input.focus();
}

// Silently refresh every 15 seconds (no page reload / no flicker)
startLiveRefresh(15000);
</script>
@endpush
@endsection
