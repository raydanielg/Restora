@extends('layouts.dashboard')

@section('title', 'Kitchen - Restora')
@section('page_title', 'Kitchen Dashboard')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-3 gap-3 sm:gap-4 mb-6">
    <div class="bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl border border-amber-300 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-amber-50">In Queue</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['queue'] }}</p>
    </div>
    <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl border border-sky-400 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-sky-100">Preparing</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['preparing'] }}</p>
    </div>
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl border border-emerald-500 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-emerald-100">Done Today</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['readyToday'] }}</p>
    </div>
</div>

{{-- Order Queue --}}
<h3 class="text-sm font-bold text-gray-900 mb-3">Order Queue</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    @forelse($orders as $order)
    <div class="bg-white rounded-xl border-2 {{ $order->status === 'preparing' ? 'border-sky-300' : 'border-amber-300' }} overflow-hidden">
        <div class="px-4 py-3 {{ $order->status === 'preparing' ? 'bg-sky-50' : 'bg-amber-50' }} flex items-center justify-between">
            <div>
                <p class="text-sm font-extrabold text-gray-900">{{ $order->table?->table_number ?? 'Takeaway' }}</p>
                <p class="text-[10px] font-mono text-gray-500">{{ $order->order_number }}</p>
            </div>
            <div class="text-right">
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $order->status === 'preparing' ? 'bg-sky-100 text-sky-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ ucfirst($order->status) }}
                </span>
                <p class="text-[10px] text-gray-400 mt-0.5">{{ $order->accepted_at?->diffForHumans() ?? $order->created_at->diffForHumans() }}</p>
            </div>
        </div>
        <div class="p-4 space-y-1.5">
            @foreach($order->items as $item)
            <div class="flex items-start justify-between">
                <p class="text-sm font-bold text-gray-800">{{ $item->quantity }}x {{ $item->menu_item_name }}</p>
            </div>
            @if($item->special_instructions)
            <p class="text-[11px] text-orange-600 italic pl-2">→ {{ $item->special_instructions }}</p>
            @endif
            @endforeach
            @if($order->notes)
            <p class="text-[11px] text-gray-500 italic pt-1 border-t mt-2">Note: {{ $order->notes }}</p>
            @endif
        </div>
        <div class="p-3 border-t bg-gray-50/50">
            @if($order->status === 'accepted')
            <form data-ajax action="{{ route('kitchen.status', $order) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="preparing">
                <button type="submit" class="w-full py-2.5 text-sm font-extrabold bg-sky-600 text-white rounded-lg hover:bg-sky-700 transition-colors">Start Preparing</button>
            </form>
            @else
            <form data-ajax action="{{ route('kitchen.status', $order) }}" method="POST">
                @csrf @method('PATCH')
                <input type="hidden" name="status" value="ready">
                <button type="submit" class="w-full py-2.5 text-sm font-extrabold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Mark as Ready</button>
            </form>
            @endif
        </div>
    </div>
    @empty
    <div class="sm:col-span-2 lg:col-span-3 bg-white rounded-xl border p-12 text-center">
        <svg class="w-14 h-14 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 13l4 4L19 7"/></svg>
        <p class="text-gray-500 font-medium">No orders in queue</p>
        <p class="text-gray-400 text-sm mt-1">New orders will appear here automatically</p>
    </div>
    @endforelse
</div>

{{-- Recently Ready --}}
@if($readyOrders->isNotEmpty())
<h3 class="text-sm font-bold text-gray-900 mb-3">Ready for Pickup</h3>
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="divide-y divide-gray-100">
        @foreach($readyOrders as $order)
        <div class="flex items-center gap-3 px-5 py-3">
            <div class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">
                {{ strtoupper(substr($order->table?->table_number ?? 'TA', 0, 3)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-medium text-gray-900">{{ $order->order_number }} &middot; {{ $order->items->count() }} items</p>
                <p class="text-xs text-gray-400">Ready {{ $order->updated_at->diffForHumans() }}</p>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">Waiting for waiter</span>
        </div>
        @endforeach
    </div>
</div>
@endif

@push('scripts')
<script>
// Silently refresh the kitchen queue every 15 seconds (no page reload / no flicker)
startLiveRefresh(15000);
</script>
@endpush
@endsection
