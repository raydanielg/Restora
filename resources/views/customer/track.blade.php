<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Order {{ $order->order_number }} - {{ $order->restaurant->name }}</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: { 50:'#e6f5f1',100:'#b3e0d4',200:'#80cbc0',300:'#4db5a8',400:'#1a9f8e',500:'#024938',600:'#023d30',700:'#013028',800:'#01241f',900:'#001816' },
                        gold: { 50:'#fff5e0',100:'#ffe6b3',200:'#ffd680',300:'#ffc64d',400:'#ffb71a',500:'#f9ac00',600:'#d49700',700:'#b07c00',800:'#8c6100',900:'#684600' }
                    },
                    fontFamily: { sans: ['Nunito', 'sans-serif'] }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Nunito', sans-serif; }
        @keyframes pulse-ring { 0% { box-shadow: 0 0 0 0 rgba(26,159,142,0.4) } 70% { box-shadow: 0 0 0 12px rgba(26,159,142,0) } 100% { box-shadow: 0 0 0 0 rgba(26,159,142,0) } }
        .pulse-active { animation: pulse-ring 1.8s infinite; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

<div class="max-w-lg mx-auto px-4 py-6">
    {{-- Header --}}
    <div class="text-center mb-6">
        <div class="w-14 h-14 rounded-2xl bg-emerald-700 text-white flex items-center justify-center mx-auto mb-3">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <h1 class="text-lg font-extrabold text-gray-900">Order {{ $order->order_number }}</h1>
        <p class="text-sm text-gray-500">{{ $order->restaurant->name }}@if($order->table) &middot; {{ $order->table->table_number }}@endif</p>
    </div>

    {{-- Status Timeline --}}
    @php
        $steps = ['pending' => 'Order Received', 'accepted' => 'Accepted', 'preparing' => 'Preparing', 'ready' => 'Ready', 'served' => 'Served', 'completed' => 'Completed'];
        $stepKeys = array_keys($steps);
        $currentIdx = array_search($order->status, $stepKeys);
        if ($currentIdx === false) $currentIdx = -1; // cancelled
    @endphp

    <div class="bg-white rounded-2xl border p-5 mb-4">
        @if($order->status === 'cancelled')
        <div class="text-center py-4">
            <div class="w-12 h-12 rounded-full bg-red-100 text-red-600 flex items-center justify-center mx-auto mb-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </div>
            <p class="font-bold text-red-600">Order Cancelled</p>
        </div>
        @else
        <div class="space-y-0" id="timeline">
            @foreach($steps as $key => $label)
            @php $idx = array_search($key, $stepKeys); @endphp
            <div class="flex gap-3 timeline-step" data-step="{{ $key }}">
                <div class="flex flex-col items-center">
                    <div class="step-dot w-8 h-8 rounded-full flex items-center justify-center shrink-0 {{ $idx < $currentIdx ? 'bg-emerald-600 text-white' : ($idx === $currentIdx ? 'bg-emerald-500 text-white pulse-active' : 'bg-gray-100 text-gray-300') }}">
                        @if($idx < $currentIdx)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        @else
                        <span class="w-2.5 h-2.5 rounded-full {{ $idx === $currentIdx ? 'bg-white' : 'bg-gray-300' }}"></span>
                        @endif
                    </div>
                    @if(!$loop->last)
                    <div class="w-0.5 h-8 {{ $idx < $currentIdx ? 'bg-emerald-500' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
                <div class="pt-1.5">
                    <p class="text-sm font-bold {{ $idx <= $currentIdx ? 'text-gray-900' : 'text-gray-400' }}">{{ $label }}</p>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    {{-- Order Items --}}
    <div class="bg-white rounded-2xl border overflow-hidden mb-4">
        <div class="px-5 py-3 border-b bg-gray-50/50">
            <h3 class="text-sm font-bold text-gray-900">Order Details</h3>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($order->items as $item)
            <div class="flex items-center justify-between px-5 py-3">
                <div>
                    <p class="text-sm font-medium text-gray-900">{{ $item->quantity }}x {{ $item->menu_item_name }}</p>
                    @if($item->special_instructions)
                    <p class="text-xs text-gray-400">{{ $item->special_instructions }}</p>
                    @endif
                </div>
                <span class="text-sm font-bold text-gray-900">{{ $order->restaurant->currency }} {{ number_format($item->price * $item->quantity) }}</span>
            </div>
            @endforeach
        </div>
        <div class="px-5 py-3 border-t bg-gray-50/50 space-y-1 text-xs">
            <div class="flex justify-between text-gray-500"><span>Subtotal</span><span>{{ $order->restaurant->currency }} {{ number_format($order->subtotal) }}</span></div>
            <div class="flex justify-between text-gray-500"><span>Tax</span><span>{{ $order->restaurant->currency }} {{ number_format($order->tax_amount) }}</span></div>
            @if($order->service_charge > 0)
            <div class="flex justify-between text-gray-500"><span>Service Charge</span><span>{{ $order->restaurant->currency }} {{ number_format($order->service_charge) }}</span></div>
            @endif
            <div class="flex justify-between text-sm font-extrabold text-gray-900 pt-1"><span>Total</span><span>{{ $order->restaurant->currency }} {{ number_format($order->total) }}</span></div>
        </div>
    </div>

    {{-- Back to Menu --}}
    @if($order->table)
    <a href="{{ route('customer.table', $order->table->qr_code) }}" class="block w-full py-3 text-center text-sm font-bold text-emerald-700 border-2 border-emerald-700 rounded-xl hover:bg-emerald-50 transition-colors">
        Order More Items
    </a>
    @endif

    <p class="text-center text-[11px] text-gray-400 mt-6">Powered by Restora OS</p>
</div>

<script>
// Live polling every 8 seconds
@if(!in_array($order->status, ['completed', 'cancelled']))
setInterval(async () => {
    try {
        const res = await fetch('{{ route('customer.order.status', $order->order_number) }}');
        const data = await res.json();
        if (data.status !== '{{ $order->status }}') {
            location.reload();
        }
    } catch (e) {}
}, 8000);
@endif
</script>

</body>
</html>
