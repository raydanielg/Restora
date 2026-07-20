@extends('layouts.dashboard')

@section('title', 'Reports - Restora')
@section('page_title', 'Reports & Analytics')

@section('content')
@php $fmt = fn($n) => $n >= 1000000000 ? number_format($n/1000000000,2).'B' : ($n >= 1000000 ? number_format($n/1000000,2).'M' : ($n >= 1000 ? number_format($n/1000,1).'K' : number_format($n))); @endphp

<div class="mb-6">
    <h2 class="text-lg font-bold text-gray-900">Reports & Analytics</h2>
    <p class="text-sm text-gray-500">Business performance overview for the last 30 days</p>
</div>

{{-- Summary KPIs --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
    <div class="card-hover bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl border border-emerald-500 p-4 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -mr-8 -mt-8"></div>
        <div class="relative z-10">
            <span class="text-[10px] font-medium text-emerald-100">Total Revenue</span>
            <p class="text-xl font-bold mt-1">TSh {{ $fmt($totalRevenue) }}</p>
        </div>
    </div>
    <div class="card-hover bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl border border-sky-400 p-4 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -mr-8 -mt-8"></div>
        <div class="relative z-10">
            <span class="text-[10px] font-medium text-sky-100">Total Orders</span>
            <p class="text-xl font-bold mt-1">{{ number_format($totalOrders) }}</p>
        </div>
    </div>
    <div class="card-hover bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl border border-violet-400 p-4 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -mr-8 -mt-8"></div>
        <div class="relative z-10">
            <span class="text-[10px] font-medium text-violet-100">Completed</span>
            <p class="text-xl font-bold mt-1">{{ number_format($completedOrders) }}</p>
        </div>
    </div>
    <div class="card-hover bg-gradient-to-br from-red-500 to-red-600 rounded-xl border border-red-400 p-4 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-16 h-16 bg-white/10 rounded-full -mr-8 -mt-8"></div>
        <div class="relative z-10">
            <span class="text-[10px] font-medium text-red-100">Cancelled</span>
            <p class="text-xl font-bold mt-1">{{ number_format($cancelledOrders) }}</p>
        </div>
    </div>
</div>

{{-- Revenue Chart --}}
<div class="bg-white rounded-xl border p-5 mb-6">
    <h3 class="text-sm font-semibold text-gray-900 mb-4">Revenue (Last 30 Days)</h3>
    @php $revMax = max($dailyRevenue) ?: 1; @endphp
    <div class="flex items-end gap-[2px] h-40">
        @foreach($dailyRevenue as $i => $rev)
        @php $pct = min(100, ($rev / $revMax) * 100); @endphp
        <div class="flex-1 flex flex-col items-center group cursor-pointer" title="Day {{ $i+1 }}: TSh {{ number_format($rev) }}">
            <div class="w-full bg-gray-50 rounded-t-sm relative h-32 overflow-hidden">
                <div class="absolute bottom-0 left-0 right-0 rounded-t-sm bg-emerald-400 hover:bg-emerald-500 transition-colors" style="height: {{ max($pct, 2) }}%"></div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Top Dishes --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="text-sm font-semibold text-gray-900">Top Selling Dishes</h3>
        </div>
        <div class="p-5 space-y-3">
            @forelse($topDishes as $dish)
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-xs shrink-0">
                    {{ strtoupper(substr($dish->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate">{{ $dish->name }}</p>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1">
                        <div class="bg-emerald-500 h-1.5 rounded-full" style="width: {{ $topDishes->first() && $topDishes->first()->total_sold > 0 ? ($dish->total_sold / $topDishes->first()->total_sold * 100) : 0 }}%"></div>
                    </div>
                </div>
                <span class="text-xs font-semibold text-gray-700 shrink-0">{{ $dish->total_sold ?? 0 }} sold</span>
            </div>
            @empty
            <p class="text-sm text-gray-400 text-center py-4">No data available</p>
            @endforelse
        </div>
    </div>

    {{-- Payment Breakdown --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="text-sm font-semibold text-gray-900">Payment Methods</h3>
        </div>
        <div class="p-5 space-y-4">
            @php $totalPayments = array_sum($paymentBreakdown) ?: 1; @endphp
            @foreach(['cash' => 'Cash', 'mobile_money' => 'Mobile Money', 'card' => 'Card'] as $key => $label)
            <div>
                <div class="flex justify-between mb-1">
                    <span class="text-xs font-medium text-gray-700">{{ $label }}</span>
                    <span class="text-xs font-semibold text-gray-900">TSh {{ $fmt($paymentBreakdown[$key] ?? 0) }}</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="h-2 rounded-full {{ $key === 'cash' ? 'bg-emerald-500' : '' }}{{ $key === 'mobile_money' ? 'bg-amber-500' : '' }}{{ $key === 'card' ? 'bg-sky-500' : '' }}" style="width: {{ (($paymentBreakdown[$key] ?? 0) / $totalPayments) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Staff Performance --}}
<div class="bg-white rounded-xl border overflow-hidden">
    <div class="px-5 py-4 border-b">
        <h3 class="text-sm font-semibold text-gray-900">Staff Performance</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Staff</th>
                    <th class="px-5 py-3 font-medium">Role</th>
                    <th class="px-5 py-3 font-medium">Orders Handled</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staffPerformance as $staff)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-7 h-7 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-white font-bold text-[10px]">
                                {{ strtoupper(substr($staff->name, 0, 1)) }}
                            </div>
                            <span class="text-xs font-medium text-gray-900">{{ $staff->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-700">{{ ucfirst($staff->role) }}</td>
                    <td class="px-5 py-3 text-xs font-semibold text-gray-900">{{ $staff->orders_handled }}</td>
                </tr>
                @empty
                <tr><td colspan="3" class="px-5 py-8 text-center text-gray-400 text-xs">No staff data</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
