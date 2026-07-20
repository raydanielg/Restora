@extends('layouts.dashboard')

@section('title', 'New Order - Restora')
@section('page_title', 'Create New Order')

@section('content')
<div class="mb-6">
    <a href="{{ route('orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700 inline-flex items-center gap-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to Orders
    </a>
</div>

<form action="{{ route('orders.store') }}" method="POST" id="order-form">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Menu Selection --}}
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl border p-5">
                <h3 class="text-sm font-bold text-gray-900 mb-4">Select Items</h3>
                <div class="space-y-4">
                    @foreach($categories as $category)
                    <div>
                        <p class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">{{ $category->name }}</p>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($category->menuItems as $item)
                            <label class="cursor-pointer">
                                <div class="border rounded-lg p-3 hover:border-emerald-500 hover:bg-emerald-50/30 transition-all {{ in_array($item->id, array_column(session()->getOldInput('items', []), 'menu_item_id') ?? []) ? 'border-emerald-500 bg-emerald-50' : '' }}">
                                    <div class="flex items-start justify-between mb-1">
                                        <p class="text-xs font-medium text-gray-900 leading-tight">{{ $item->name }}</p>
                                        <span class="text-[10px] font-bold text-emerald-600 shrink-0 ml-1">TSh {{ number_format($item->price) }}</span>
                                    </div>
                                    <p class="text-[10px] text-gray-400 line-clamp-1">{{ $item->description ?? '' }}</p>
                                    <div class="mt-2 flex items-center gap-1">
                                        <input type="checkbox" name="items[{{ $item->id }}][menu_item_id]" value="{{ $item->id }}" class="item-checkbox rounded text-emerald-600" data-price="{{ $item->price }}" data-name="{{ $item->name }}" {{ $item->is_available ? '' : 'disabled' }}>
                                        <span class="text-[10px] text-gray-400">{{ $item->is_available ? 'Available' : 'Unavailable' }}</span>
                                    </div>
                                    <input type="number" name="items[{{ $item->id }}][quantity]" min="1" value="1" class="qty-input hidden mt-2 w-full text-xs px-2 py-1 border border-gray-200 rounded" placeholder="Qty">
                                    <input type="text" name="items[{{ $item->id }}][special_instructions]" class="instructions-input hidden mt-1 w-full text-[10px] px-2 py-1 border border-gray-200 rounded" placeholder="Special instructions">
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                    @if($categories->isEmpty())
                    <div class="text-center py-8 text-gray-400 text-sm">No menu items available. Add items first.</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Order Summary --}}
        <div class="space-y-4">
            <div class="bg-white rounded-xl border p-5">
                <h3 class="text-sm font-bold text-gray-900 mb-4">Order Details</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Order Type</label>
                        <select name="order_type" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                            <option value="dine_in">Dine In</option>
                            <option value="takeaway">Takeaway</option>
                            <option value="delivery">Delivery</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Table</label>
                        <select name="table_id" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                            <option value="">No table (takeaway)</option>
                            @foreach($tables as $table)
                            <option value="{{ $table->id }}">{{ $table->table_number }} ({{ $table->capacity }} seats)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Customer Name</label>
                            <input type="text" name="customer_name" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm" placeholder="Optional">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" name="customer_phone" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm" placeholder="Optional">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Notes</label>
                        <textarea name="notes" rows="2" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm" placeholder="Order notes..."></textarea>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border p-5">
                <h3 class="text-sm font-bold text-gray-900 mb-3">Summary</h3>
                <div id="order-summary" class="space-y-1 text-xs text-gray-600 mb-3 min-h-[40px]">
                    <p class="text-gray-400">Select items to see summary</p>
                </div>
                <div class="border-t pt-3 space-y-1 text-xs">
                    <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span id="subtotal" class="font-medium text-gray-900">TSh 0</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Tax ({{ $restaurant->tax_rate }}%)</span><span id="tax" class="font-medium text-gray-900">TSh 0</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Service Charge</span><span id="service" class="font-medium text-gray-900">TSh 0</span></div>
                    <div class="flex justify-between text-sm font-bold pt-1"><span class="text-gray-900">Total</span><span id="total" class="text-emerald-600">TSh 0</span></div>
                </div>
                <button type="submit" class="w-full mt-4 px-4 py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Place Order</button>
            </div>
        </div>
    </div>
</form>

<script>
document.querySelectorAll('.item-checkbox').forEach(cb => {
    cb.addEventListener('change', function() {
        const card = this.closest('.border');
        const qty = card.querySelector('.qty-input');
        const instr = card.querySelector('.instructions-input');
        if (this.checked) {
            qty.classList.remove('hidden');
            instr.classList.remove('hidden');
        } else {
            qty.classList.add('hidden');
            instr.classList.add('hidden');
        }
        updateSummary();
    });
});

document.querySelectorAll('.qty-input').forEach(input => {
    input.addEventListener('input', updateSummary);
});

function updateSummary() {
    let subtotal = 0;
    let summaryHtml = '';
    document.querySelectorAll('.item-checkbox:checked').forEach(cb => {
        const card = cb.closest('.border');
        const qty = card.querySelector('.qty-input');
        const qtyVal = parseInt(qty.value) || 1;
        const price = parseFloat(cb.dataset.price);
        const name = cb.dataset.name;
        const lineTotal = price * qtyVal;
        subtotal += lineTotal;
        summaryHtml += `<div class="flex justify-between"><span>${name} x${qtyVal}</span><span>TSh ${numberFormat(lineTotal)}</span></div>`;
    });
    const taxRate = {{ $restaurant->tax_rate }};
    const serviceRate = {{ $restaurant->service_charge }};
    const tax = subtotal * taxRate / 100;
    const service = subtotal * serviceRate / 100;
    const total = subtotal + tax + service;

    document.getElementById('order-summary').innerHTML = summaryHtml || '<p class="text-gray-400">Select items to see summary</p>';
    document.getElementById('subtotal').textContent = 'TSh ' + numberFormat(subtotal);
    document.getElementById('tax').textContent = 'TSh ' + numberFormat(tax);
    document.getElementById('service').textContent = 'TSh ' + numberFormat(service);
    document.getElementById('total').textContent = 'TSh ' + numberFormat(total);
}

function numberFormat(n) {
    return Math.round(n).toLocaleString();
}
</script>
@endsection
