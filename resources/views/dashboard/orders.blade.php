@extends('layouts.dashboard')

@section('title', 'Orders - Restora')
@section('page_title', 'Orders')

@section('content')
<div class="mb-6 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="text-lg font-bold text-gray-900">Orders</h2>
        <p class="text-sm text-gray-500">Manage all customer orders</p>
    </div>
    <a href="{{ route('orders.create') }}" class="px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors inline-flex items-center gap-1.5">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Order
    </a>
</div>

<div class="bg-white rounded-xl border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Order #</th>
                    <th class="px-5 py-3 font-medium">Table</th>
                    <th class="px-5 py-3 font-medium">Items</th>
                    <th class="px-5 py-3 font-medium">Total</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Time</th>
                    <th class="px-5 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3">
                        <a href="{{ route('orders.show', $order) }}" class="font-mono text-xs text-emerald-600 hover:text-emerald-700 font-medium">{{ $order->order_number }}</a>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-700">{{ $order->table?->table_number ?? 'Takeaway' }}</td>
                    <td class="px-5 py-3 text-xs text-gray-700">{{ $order->items->count() }} items</td>
                    <td class="px-5 py-3 text-xs font-semibold text-gray-900">TSh {{ number_format($order->total) }}</td>
                    <td class="px-5 py-3">
                        @php
                            $statusColors = [
                                'pending' => 'bg-red-50 text-red-700 border-red-200',
                                'accepted' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'preparing' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'ready' => 'bg-violet-50 text-violet-700 border-violet-200',
                                'served' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
                                'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                'cancelled' => 'bg-gray-50 text-gray-500 border-gray-200',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium border {{ $statusColors[$order->status] ?? '' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-400">{{ $order->created_at->format('M d, H:i') }}</td>
                    <td class="px-5 py-3">
                        <form data-ajax data-reset-on-success="false" action="{{ route('orders.status', $order) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.requestSubmit()" class="text-[10px] border border-gray-200 rounded-md px-1.5 py-1 outline-none focus:border-emerald-500">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="accepted" {{ $order->status === 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                <option value="ready" {{ $order->status === 'ready' ? 'selected' : '' }}>Ready</option>
                                <option value="served" {{ $order->status === 'served' ? 'selected' : '' }}>Served</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-5 py-12 text-center text-gray-400">
                        <p class="text-sm font-medium">No orders yet</p>
                        <p class="text-xs mt-1">Create your first order to get started</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{ $orders->withQueryString()->links() }}
@endsection
