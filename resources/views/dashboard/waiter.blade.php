@extends('layouts.dashboard')

@section('title', 'Waiter - Restora')
@section('page_title', 'Waiter Dashboard')

@section('content')
{{-- Stats --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl border border-emerald-500 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-emerald-100">Ready to Serve</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['ready'] }}</p>
    </div>
    <div class="bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl border border-sky-400 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-sky-100">Active Orders</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['active'] }}</p>
    </div>
    <div class="bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl border border-violet-400 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-violet-100">Served Today</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['servedToday'] }}</p>
    </div>
    <div class="bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl border border-amber-300 p-4 text-white">
        <span class="text-[10px] sm:text-xs font-medium text-amber-50">Occupied Tables</span>
        <p class="text-2xl sm:text-3xl font-bold mt-1">{{ $stats['occupiedTables'] }}</p>
    </div>
</div>

{{-- Ready Meals (Priority) --}}
@if($readyOrders->isNotEmpty())
<h3 class="text-sm font-bold text-gray-900 mb-3 flex items-center gap-2">
    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
    Ready Meals — Serve Now!
</h3>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    @foreach($readyOrders as $order)
    <div class="bg-white rounded-xl border-2 border-emerald-300 overflow-hidden">
        <div class="px-4 py-3 bg-emerald-50 flex items-center justify-between">
            <div>
                <p class="text-sm font-extrabold text-gray-900">{{ $order->table?->table_number ?? 'Takeaway' }}</p>
                <p class="text-[10px] font-mono text-gray-500">{{ $order->order_number }}</p>
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">READY</span>
        </div>
        <div class="p-4 space-y-1">
            @foreach($order->items as $item)
            <p class="text-sm text-gray-800">{{ $item->quantity }}x {{ $item->menu_item_name }}</p>
            @endforeach
        </div>
        <div class="p-3 border-t">
            <form action="{{ route('waiter.serve', $order) }}" method="POST">
                @csrf @method('PATCH')
                <button class="w-full py-2.5 text-sm font-extrabold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Mark as Served</button>
            </form>
        </div>
    </div>
    @endforeach
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Active Orders --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="text-sm font-bold text-gray-900">Active Orders</h3>
        </div>
        <div class="divide-y divide-gray-100 max-h-[420px] overflow-y-auto">
            @forelse($activeOrders as $order)
            <div class="flex items-center gap-3 px-5 py-3">
                <div class="w-9 h-9 rounded-lg bg-gray-100 flex items-center justify-center font-bold text-[10px] text-gray-600 shrink-0">
                    {{ strtoupper(substr($order->table?->table_number ?? 'TA', 0, 3)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $order->order_number }}</p>
                    <p class="text-xs text-gray-400">{{ $order->items->count() }} items &middot; TSh {{ number_format($order->total) }}</p>
                </div>
                @php
                    $statusColors = [
                        'pending' => 'bg-red-50 text-red-700 border-red-200',
                        'accepted' => 'bg-sky-50 text-sky-700 border-sky-200',
                        'preparing' => 'bg-amber-50 text-amber-700 border-amber-200',
                        'served' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                    ];
                @endphp
                <div class="text-right shrink-0">
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium border {{ $statusColors[$order->status] ?? '' }}">{{ ucfirst($order->status) }}</span>
                    @if($order->status === 'served' && !$order->payments->where('status', 'confirmed')->count())
                    <form action="{{ route('waiter.collect', $order) }}" method="POST" class="mt-1">
                        @csrf
                        <button class="text-[10px] font-bold text-gold-600 hover:text-gold-700 underline">Collect Cash</button>
                    </form>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-5 py-10 text-center text-gray-400 text-sm">No active orders</div>
            @endforelse
        </div>
    </div>

    {{-- Tables Overview --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="text-sm font-bold text-gray-900">Tables</h3>
        </div>
        <div class="p-4 grid grid-cols-3 sm:grid-cols-4 gap-3">
            @foreach($tables as $table)
            <div class="rounded-lg p-3 text-center border-2
                {{ $table->status === 'available' ? 'border-emerald-200 bg-emerald-50' : '' }}
                {{ $table->status === 'occupied' ? 'border-red-200 bg-red-50' : '' }}
                {{ $table->status === 'reserved' ? 'border-amber-200 bg-amber-50' : '' }}">
                <p class="text-xs font-extrabold {{ $table->status === 'available' ? 'text-emerald-700' : ($table->status === 'occupied' ? 'text-red-700' : 'text-amber-700') }}">{{ $table->table_number }}</p>
                <p class="text-[9px] text-gray-500 mt-0.5">{{ ucfirst($table->status) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
// Auto-refresh every 20 seconds
setTimeout(() => location.reload(), 20000);
</script>
@endpush
@endsection
