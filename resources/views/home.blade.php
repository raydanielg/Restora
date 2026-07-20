@extends('layouts.dashboard')

@section('title', 'Dashboard - ' . config('app.name', 'Restora'))
@section('page_title', 'Dashboard Overview')

@section('content')
@php
    $fmt = fn($n) => $n >= 1000000000 ? number_format($n/1000000000,2).'B' : ($n >= 1000000 ? number_format($n/1000000,2).'M' : ($n >= 1000 ? number_format($n/1000,1).'K' : number_format($n)));
@endphp

<style>
    .circle-bg { stroke: #f3f4f6; }
    .circle-fill { transition: stroke-dashoffset 1.2s ease-out; }
    @keyframes growBar { from { height: 0 } }
    .grow-bar { animation: growBar 0.8s ease-out; }
</style>

{{-- Welcome --}}
<div class="mb-6 flex flex-row items-start sm:items-center justify-between gap-3 flex-wrap">
    <div class="min-w-0">
        <h1 class="text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Welcome back, {{ Auth::user()->name ?? 'Admin' }} 👋</h1>
        <p class="text-xs sm:text-sm text-gray-500 mt-0.5">Here's what's happening with your restaurant today.</p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
        <button class="px-3 py-1.5 text-xs font-medium border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span class="hidden sm:inline">Today</span>
        </button>
        <a href="#" class="px-3 py-1.5 text-xs font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors inline-flex items-center gap-1.5">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span>New Order</span>
        </a>
    </div>
</div>

{{-- KPI Stats Cards --}}
<div class="grid grid-cols-2 gap-3 sm:gap-4 xl:grid-cols-4 mb-6">
    {{-- Total Revenue --}}
    <div class="card-hover bg-gradient-to-br from-emerald-600 to-emerald-700 rounded-xl border border-emerald-500 p-3 sm:p-5 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
        <div class="flex items-start justify-between relative z-10">
            <span class="text-[10px] sm:text-xs font-medium text-emerald-100">Total Revenue</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-white relative z-10">TSh {{ $fmt(2450000) }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-emerald-200 font-medium relative z-10">+12.5% vs last week</div>
    </div>

    {{-- Total Orders --}}
    <div class="card-hover bg-gradient-to-br from-sky-500 to-sky-600 rounded-xl border border-sky-400 p-3 sm:p-5 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
        <div class="flex items-start justify-between relative z-10">
            <span class="text-[10px] sm:text-xs font-medium text-sky-100">Total Orders</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-sky-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <div class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-white relative z-10">1,847</div>
        <div class="mt-1 text-[10px] sm:text-xs text-sky-100 font-medium relative z-10">+84 today</div>
    </div>

    {{-- Active Tables --}}
    <div class="card-hover bg-gradient-to-br from-amber-400 to-amber-500 rounded-xl border border-amber-300 p-3 sm:p-5 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
        <div class="flex items-start justify-between relative z-10">
            <span class="text-[10px] sm:text-xs font-medium text-amber-50">Active Tables</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6M9 14h6"/></svg>
        </div>
        <div class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-white relative z-10">18 / 24</div>
        <div class="mt-1 text-[10px] sm:text-xs text-amber-50 font-medium relative z-10">75% occupancy</div>
    </div>

    {{-- Avg Order Value --}}
    <div class="card-hover bg-gradient-to-br from-violet-500 to-violet-600 rounded-xl border border-violet-400 p-3 sm:p-5 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white/10 rounded-full -mr-10 -mt-10"></div>
        <div class="flex items-start justify-between relative z-10">
            <span class="text-[10px] sm:text-xs font-medium text-violet-100">Avg Order Value</span>
            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <div class="mt-2 sm:mt-3 text-xl sm:text-3xl font-bold tracking-tight text-white relative z-10">TSh {{ $fmt(13280) }}</div>
        <div class="mt-1 text-[10px] sm:text-xs text-violet-100 font-medium relative z-10">+3.2% vs yesterday</div>
    </div>
</div>

{{-- Circular Progress + Revenue Chart Row --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 mb-6">

    {{-- Circular Progress Widgets --}}
    <div class="bg-white rounded-xl border p-5">
        <h3 class="text-sm font-semibold text-gray-900 mb-1">Performance</h3>
        <p class="text-xs text-gray-400 mb-5">Today's key metrics</p>

        <div class="grid grid-cols-2 gap-4">
            {{-- Circle 1: Order Completion --}}
            @php
                $pct1 = 78;
                $r1 = 34;
                $circ1 = 2 * pi() * $r1;
                $off1 = $circ1 - ($circ1 * $pct1 / 100);
            @endphp
            <div class="flex flex-col items-center">
                <div class="relative w-24 h-24">
                    <svg class="w-24 h-24 -rotate-90" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="{{ $r1 }}" fill="none" class="circle-bg" stroke-width="7"/>
                        <circle cx="40" cy="40" r="{{ $r1 }}" fill="none" stroke="#10b981" stroke-width="7" stroke-linecap="round"
                            style="--circumference: {{ $circ1 }}; --offset: {{ $off1 }}; stroke-dasharray: {{ $circ1 }}; stroke-dashoffset: {{ $off1 }};"
                            class="circle-fill"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg font-bold text-gray-900">{{ $pct1 }}%</span>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-700 mt-2 text-center">Order Completion</p>
                <p class="text-[10px] text-gray-400">142 of 182 orders</p>
            </div>

            {{-- Circle 2: Table Occupancy --}}
            @php
                $pct2 = 75;
                $r2 = 34;
                $circ2 = 2 * pi() * $r2;
                $off2 = $circ2 - ($circ2 * $pct2 / 100);
            @endphp
            <div class="flex flex-col items-center">
                <div class="relative w-24 h-24">
                    <svg class="w-24 h-24 -rotate-90" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="{{ $r2 }}" fill="none" class="circle-bg" stroke-width="7"/>
                        <circle cx="40" cy="40" r="{{ $r2 }}" fill="none" stroke="#f59e0b" stroke-width="7" stroke-linecap="round"
                            style="--circumference: {{ $circ2 }}; --offset: {{ $off2 }}; stroke-dasharray: {{ $circ2 }}; stroke-dashoffset: {{ $off2 }};"
                            class="circle-fill"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg font-bold text-gray-900">{{ $pct2 }}%</span>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-700 mt-2 text-center">Table Occupancy</p>
                <p class="text-[10px] text-gray-400">18 of 24 tables</p>
            </div>

            {{-- Circle 3: Customer Satisfaction --}}
            @php
                $pct3 = 92;
                $r3 = 34;
                $circ3 = 2 * pi() * $r3;
                $off3 = $circ3 - ($circ3 * $pct3 / 100);
            @endphp
            <div class="flex flex-col items-center">
                <div class="relative w-24 h-24">
                    <svg class="w-24 h-24 -rotate-90" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="{{ $r3 }}" fill="none" class="circle-bg" stroke-width="7"/>
                        <circle cx="40" cy="40" r="{{ $r3 }}" fill="none" stroke="#8b5cf6" stroke-width="7" stroke-linecap="round"
                            style="--circumference: {{ $circ3 }}; --offset: {{ $off3 }}; stroke-dasharray: {{ $circ3 }}; stroke-dashoffset: {{ $off3 }};"
                            class="circle-fill"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg font-bold text-gray-900">{{ $pct3 }}%</span>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-700 mt-2 text-center">Satisfaction</p>
                <p class="text-[10px] text-gray-400">4.6 / 5.0 rating</p>
            </div>

            {{-- Circle 4: Inventory Health --}}
            @php
                $pct4 = 65;
                $r4 = 34;
                $circ4 = 2 * pi() * $r4;
                $off4 = $circ4 - ($circ4 * $pct4 / 100);
            @endphp
            <div class="flex flex-col items-center">
                <div class="relative w-24 h-24">
                    <svg class="w-24 h-24 -rotate-90" viewBox="0 0 80 80">
                        <circle cx="40" cy="40" r="{{ $r4 }}" fill="none" class="circle-bg" stroke-width="7"/>
                        <circle cx="40" cy="40" r="{{ $r4 }}" fill="none" stroke="#0ea5e9" stroke-width="7" stroke-linecap="round"
                            style="--circumference: {{ $circ4 }}; --offset: {{ $off4 }}; stroke-dasharray: {{ $circ4 }}; stroke-dashoffset: {{ $off4 }};"
                            class="circle-fill"/>
                    </svg>
                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                        <span class="text-lg font-bold text-gray-900">{{ $pct4 }}%</span>
                    </div>
                </div>
                <p class="text-xs font-medium text-gray-700 mt-2 text-center">Inventory Health</p>
                <p class="text-[10px] text-gray-400">3 items low stock</p>
            </div>
        </div>
    </div>

    {{-- Revenue Bar Chart --}}
    <div class="lg:col-span-2 bg-white rounded-xl border p-5">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-sm font-semibold text-gray-900">Revenue Overview</h3>
                <p class="text-xs text-gray-400">Last 14 days</p>
            </div>
            <div class="text-right">
                <div class="text-lg font-semibold text-gray-900">TSh {{ $fmt(2450000) }}</div>
                <div class="text-xs text-emerald-600 font-medium">+12.5%</div>
            </div>
        </div>
        @php
            $dailyRevenue = [120,150,98,175,210,190,240,180,165,220,280,250,310,295];
            $dailyLabels = [];
            $revMax = max($dailyRevenue) ?: 1;
        @endphp
        <div class="flex items-end gap-[4px] h-44">
            @foreach($dailyRevenue as $i => $rev)
                @php $pct = min(100, ($rev / $revMax) * 100); $isToday = $i === count($dailyRevenue)-1; @endphp
                <div class="flex-1 flex flex-col items-center gap-1 group cursor-pointer" title="Day {{ $i+1 }}: TSh {{ number_format($rev * 10000) }}">
                    <div class="w-full bg-gray-50 rounded-t-md relative h-36 overflow-hidden">
                        <div class="grow-bar absolute bottom-0 left-0 right-0 rounded-t-md transition-all duration-300 {{ $isToday ? 'bg-emerald-500' : 'bg-emerald-300 hover:bg-emerald-400' }}" style="height: {{ max($pct, 3) }}%"></div>
                    </div>
                    <span class="text-[9px] text-gray-400 font-medium">{{ \Carbon\Carbon::now()->subDays(13-$i)->format('d') }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Top Dishes + Recent Orders Row --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6">

    {{-- Top Selling Dishes --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900">Top Selling Dishes</h3>
            <a href="#" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">View All</a>
        </div>
        <div class="p-5 space-y-3">
            @foreach([
                ['name' => 'Beef Burger', 'sales' => 342, 'revenue' => 4520000, 'color' => 'bg-red-100 text-red-700'],
                ['name' => 'Margherita Pizza', 'sales' => 287, 'revenue' => 5750000, 'color' => 'bg-amber-100 text-amber-700'],
                ['name' => 'Chicken Wings', 'sales' => 231, 'revenue' => 2760000, 'color' => 'bg-orange-100 text-orange-700'],
                ['name' => 'Caesar Salad', 'sales' => 198, 'revenue' => 1980000, 'color' => 'bg-emerald-100 text-emerald-700'],
                ['name' => 'Fish & Chips', 'sales' => 156, 'revenue' => 2340000, 'color' => 'bg-sky-100 text-sky-700'],
            ] as $dish)
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg {{ $dish['color'] }} flex items-center justify-center shrink-0 font-bold text-xs">
                        {{ strtoupper(substr($dish['name'], 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">{{ $dish['name'] }}</p>
                        <p class="text-xs text-gray-400">{{ $dish['sales'] }} orders</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-gray-900">TSh {{ $fmt($dish['revenue']) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b flex items-center justify-between">
            <h3 class="text-sm font-semibold text-gray-900">Recent Orders</h3>
            <a href="#" class="text-xs font-medium text-emerald-600 hover:text-emerald-700">View All</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                        <th class="px-5 py-2.5 font-medium">Order #</th>
                        <th class="px-5 py-2.5 font-medium">Table</th>
                        <th class="px-5 py-2.5 font-medium">Amount</th>
                        <th class="px-5 py-2.5 font-medium">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach([
                        ['#1047', 'T-12', 45000, 'completed'],
                        ['#1046', 'T-05', 32000, 'preparing'],
                        ['#1045', 'T-18', 78000, 'completed'],
                        ['#1044', 'T-03', 21000, 'pending'],
                        ['#1043', 'T-09', 56000, 'completed'],
                        ['#1042', 'T-15', 39000, 'served'],
                    ] as $order)
                        <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                            <td class="px-5 py-2.5 font-mono text-xs text-gray-500">{{ $order[0] }}</td>
                            <td class="px-5 py-2.5 text-xs text-gray-700">{{ $order[1] }}</td>
                            <td class="px-5 py-2.5 text-xs font-semibold text-gray-900">TSh {{ number_format($order[2]) }}</td>
                            <td class="px-5 py-2.5">
                                @if($order[3] === 'completed')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">Completed</span>
                                @elseif($order[3] === 'preparing')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-amber-50 text-amber-700 border border-amber-100">Preparing</span>
                                @elseif($order[3] === 'pending')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-red-50 text-red-700 border border-red-100">Pending</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium bg-sky-50 text-sky-700 border border-sky-100">Served</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Quick Stats Mini Card --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
    {{-- This Month Summary --}}
    <div class="bg-gradient-to-br from-gray-800 to-gray-900 rounded-xl border border-gray-700 p-5 text-white">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
                <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-white">This Month</h3>
        </div>
        <div class="space-y-4">
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Revenue</p>
                <p class="text-2xl font-bold text-white mt-1">TSh {{ $fmt(18500000) }}</p>
            </div>
            <div>
                <p class="text-[10px] text-gray-400 uppercase tracking-wider font-medium">Orders</p>
                <p class="text-2xl font-bold text-white mt-1">12,450</p>
            </div>
            <div class="pt-3 border-t border-gray-700">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full animate-pulse"></span>
                    <p class="text-[11px] text-gray-300">All systems operational</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Low Stock Alerts --}}
    <div class="bg-white rounded-xl border p-5">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Low Stock Alerts</h3>
        </div>
        <div class="space-y-3">
            @foreach([
                ['Tomatoes', 5, 'kg', 20],
                ['Chicken Breast', 8, 'kg', 25],
                ['Cooking Oil', 3, 'L', 15],
            ] as $item)
                <div class="flex items-center gap-3">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-900">{{ $item[0] }}</p>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1">
                            <div class="bg-red-500 h-1.5 rounded-full" style="width: {{ ($item[1] / $item[3]) * 100 }}%"></div>
                        </div>
                    </div>
                    <span class="text-xs font-semibold text-gray-700 shrink-0">{{ $item[1] }}{{ $item[2] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Staff On Duty --}}
    <div class="bg-white rounded-xl border p-5">
        <div class="flex items-center gap-2 mb-4">
            <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <h3 class="text-sm font-semibold text-gray-900">Staff On Duty</h3>
        </div>
        <div class="space-y-3">
            @foreach([
                ['John M.', 'Chef', 'bg-emerald-100 text-emerald-700'],
                ['Sarah K.', 'Waiter', 'bg-amber-100 text-amber-700'],
                ['David L.', 'Cashier', 'bg-sky-100 text-sky-700'],
                ['Mary T.', 'Waiter', 'bg-violet-100 text-violet-700'],
            ] as $staff)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full {{ $staff[2] }} flex items-center justify-center font-bold text-xs shrink-0">
                        {{ strtoupper(substr($staff[0], 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-medium text-gray-900 truncate">{{ $staff[0] }}</p>
                        <p class="text-[10px] text-gray-400">{{ $staff[1] }}</p>
                    </div>
                    <span class="w-2 h-2 bg-emerald-400 rounded-full shrink-0"></span>
                </div>
            @endforeach
        </div>
    </div>
</div>

{{-- Mobile Bottom Spacing --}}
<div class="h-4 lg:hidden"></div>

@endsection
