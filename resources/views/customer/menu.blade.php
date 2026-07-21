<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>{{ $restaurant->name }} - Menu</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        .cat-pill.active { background: #024938; color: white; }
        @keyframes slideUp { from { transform: translateY(100%) } to { transform: translateY(0) } }
        .slide-up { animation: slideUp 0.3s ease-out; }
        @keyframes bounce-badge { 0%,100% { transform: scale(1) } 50% { transform: scale(1.3) } }
        .badge-bounce { animation: bounce-badge 0.3s ease; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 pb-24">

{{-- Hero --}}
<div class="relative bg-gradient-to-br from-emerald-700 to-emerald-900 text-white overflow-hidden">
    @if($restaurant->cover_image)
    <div class="absolute inset-0">
        <img src="{{ asset($restaurant->cover_image) }}" class="w-full h-full object-cover opacity-30" alt="">
        <div class="absolute inset-0 bg-gradient-to-b from-emerald-900/40 via-emerald-900/70 to-emerald-900"></div>
    </div>
    @endif
    <div class="relative max-w-lg mx-auto px-4 pt-6 pb-5">
        <div class="flex items-center gap-3">
            <div class="w-14 h-14 rounded-2xl bg-white/10 border border-white/20 flex items-center justify-center shrink-0 shadow-lg overflow-hidden">
                @if($restaurant->logo)
                <img src="{{ asset($restaurant->logo) }}" class="w-full h-full object-cover" alt="{{ $restaurant->name }}">
                @else
                <span class="text-xl font-bold text-gold-400">{{ strtoupper(substr($restaurant->name, 0, 1)) }}</span>
                @endif
            </div>
            <div class="flex-1 min-w-0">
                <h1 class="text-lg font-extrabold truncate">{{ $restaurant->name }}</h1>
                <p class="text-xs text-emerald-200 truncate">{{ $restaurant->address ?? $restaurant->location }}</p>
            </div>
        </div>

        @if($table)
        <div class="mt-3 inline-flex items-center gap-1.5 bg-gold-500/20 border border-gold-400/40 rounded-full px-3 py-1">
            <svg class="w-3.5 h-3.5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/></svg>
            <span class="text-xs font-bold text-gold-200">{{ $table->table_number }}</span>
        </div>
        @else
        <div class="mt-3 inline-flex items-center gap-1.5 bg-white/10 border border-white/20 rounded-full px-3 py-1">
            <svg class="w-3.5 h-3.5 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
            <span class="text-xs font-medium text-emerald-100">Scan the QR on your table to order</span>
        </div>
        @endif

        {{-- Quick Actions --}}
        <div class="mt-5 grid grid-cols-4 gap-2.5">
            <button onclick="openOffers()" class="flex flex-col items-center gap-1.5 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl py-3 transition-colors">
                <svg class="w-5 h-5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 10V5a2 2 0 012-2z"/></svg>
                <span class="text-[10px] font-bold">Offers</span>
            </button>
            <button onclick="startServices()" class="flex flex-col items-center gap-1.5 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl py-3 transition-colors">
                <svg class="w-5 h-5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="text-[10px] font-bold">Services</span>
            </button>
            <button onclick="openPayBills()" class="flex flex-col items-center gap-1.5 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl py-3 transition-colors">
                <svg class="w-5 h-5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a4 4 0 00-8 0v2M5 9h14l1 12H4L5 9z"/></svg>
                <span class="text-[10px] font-bold">Pay Bills</span>
            </button>
            <button onclick="openMore()" class="flex flex-col items-center gap-1.5 bg-white/10 hover:bg-white/20 border border-white/10 rounded-2xl py-3 transition-colors">
                <svg class="w-5 h-5 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6h.01M12 12h.01M12 18h.01"/></svg>
                <span class="text-[10px] font-bold">More</span>
            </button>
        </div>
    </div>
</div>

@if(!$table)
{{-- No table scanned yet: menu is browse-only until a table QR is scanned --}}
<div class="max-w-lg mx-auto px-4 pt-4">
    <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 flex items-center gap-3">
        <div class="w-9 h-9 rounded-lg bg-amber-100 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
        </div>
        <div class="flex-1 min-w-0">
            <p class="text-xs font-bold text-amber-800">You're browsing only</p>
            <p class="text-[11px] text-amber-700">Scan the QR code on your table to place an order.</p>
        </div>
    </div>
</div>
@endif

{{-- Category Pills --}}
<div id="menuArea" class="sticky top-0 z-30 bg-white border-b shadow-sm">
    <div class="max-w-lg mx-auto px-4 py-3 flex gap-2 overflow-x-auto no-scrollbar">
        <button onclick="filterCategory('all', this)" class="cat-pill active shrink-0 px-4 py-1.5 rounded-full text-xs font-bold border border-gray-200 text-gray-600 transition-colors">All</button>
        @foreach($categories as $category)
        <button onclick="filterCategory('cat-{{ $category->id }}', this)" class="cat-pill shrink-0 px-4 py-1.5 rounded-full text-xs font-bold border border-gray-200 text-gray-600 transition-colors">{{ $category->name }}</button>
        @endforeach
    </div>
</div>

{{-- Menu Items --}}
<div class="max-w-lg mx-auto px-4 py-4 space-y-6">
    @foreach($categories as $category)
    <div class="menu-section" data-cat="cat-{{ $category->id }}">
        <h2 class="text-sm font-bold text-gray-800 mb-3">{{ $category->name }}</h2>
        <div class="space-y-3">
            @foreach($category->menuItems as $item)
            <div class="bg-white rounded-xl border p-3 flex gap-3 items-center">
                <div class="w-16 h-16 rounded-lg bg-emerald-50 flex items-center justify-center shrink-0 overflow-hidden">
                    @if($item->image)
                    <img src="{{ asset($item->image) }}" class="w-full h-full object-cover" alt="{{ $item->name }}">
                    @else
                    <span class="text-lg font-bold text-emerald-300">{{ strtoupper(substr($item->name, 0, 1)) }}</span>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900 leading-tight">{{ $item->name }}</p>
                    <p class="text-[11px] text-gray-400 line-clamp-1 mt-0.5">{{ $item->description }}</p>
                    <p class="text-sm font-extrabold text-emerald-600 mt-1">{{ $restaurant->currency }} {{ number_format($item->price) }}</p>
                </div>
                <div class="shrink-0 flex flex-col items-center gap-1">
                    <div class="flex items-center gap-2" id="ctrl-{{ $item->id }}">
                        <button onclick="tryAddToCart({{ $item->id }}, '{{ addslashes($item->name) }}', {{ $item->price }})" class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-700 active:scale-95 transition-all shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    @if($categories->isEmpty())
    <div class="text-center py-16 text-gray-400">
        <p class="font-medium">Menu is not available yet</p>
    </div>
    @endif
</div>

{{-- Floating Cart Button --}}
<div id="cartBar" class="hidden fixed bottom-0 left-0 right-0 z-40 p-4">
    <div class="max-w-lg mx-auto">
        <button onclick="openCart()" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white rounded-2xl px-5 py-4 flex items-center justify-between shadow-2xl active:scale-[0.99] transition-all">
            <div class="flex items-center gap-2.5">
                <div class="relative">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span id="cartBadge" class="absolute -top-2 -right-2 w-5 h-5 bg-gold-500 text-emerald-900 text-[10px] font-extrabold rounded-full flex items-center justify-center">0</span>
                </div>
                <span class="text-sm font-bold">View Cart</span>
            </div>
            <span id="cartTotal" class="text-sm font-extrabold">{{ $restaurant->currency }} 0</span>
        </button>
    </div>
</div>

{{-- Cart Drawer --}}
<div id="cartDrawer" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" onclick="closeCart()"></div>
    <div class="slide-up absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[85vh] flex flex-col">
        <div class="max-w-lg mx-auto w-full flex flex-col max-h-[85vh]">
            <div class="p-4 border-b flex items-center justify-between shrink-0">
                <h3 class="text-base font-bold text-gray-900">Your Order</h3>
                <button onclick="closeCart()" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div id="cartItems" class="flex-1 overflow-y-auto p-4 space-y-3"></div>
            <div class="p-4 border-t bg-gray-50 shrink-0 space-y-3">
                <div class="space-y-1 text-xs">
                    <div class="flex justify-between text-gray-500"><span>Subtotal</span><span id="sumSubtotal">-</span></div>
                    <div class="flex justify-between text-gray-500"><span>Tax ({{ $restaurant->tax_rate }}%)</span><span id="sumTax">-</span></div>
                    @if($restaurant->service_charge > 0)
                    <div class="flex justify-between text-gray-500"><span>Service ({{ $restaurant->service_charge }}%)</span><span id="sumService">-</span></div>
                    @endif
                    <div class="flex justify-between text-sm font-extrabold text-gray-900 pt-1"><span>Total</span><span id="sumTotal">-</span></div>
                </div>
                <input type="text" id="custName" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500" placeholder="Your name (optional)">
                <input type="text" id="custPhone" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm outline-none focus:border-emerald-500" placeholder="Phone number (optional)">
                <button onclick="placeOrder()" id="placeBtn" class="w-full py-3.5 bg-emerald-700 hover:bg-emerald-800 text-white rounded-xl text-sm font-extrabold active:scale-[0.99] transition-all">
                    Place Order
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Offers Modal --}}
<div id="offersModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" onclick="closeSheet('offersModal')"></div>
    <div class="slide-up absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[75vh] flex flex-col">
        <div class="max-w-lg mx-auto w-full flex flex-col">
            <div class="p-4 border-b flex items-center justify-between shrink-0">
                <h3 class="text-base font-bold text-gray-900">Offers</h3>
                <button onclick="closeSheet('offersModal')" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-6 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 10V5a2 2 0 012-2z"/></svg>
                <p class="text-sm font-medium">No active offers right now</p>
                <p class="text-xs mt-1">Check back soon — {{ $restaurant->name }} posts specials here.</p>
            </div>
        </div>
    </div>
</div>

{{-- More Modal (restaurant info) --}}
<div id="moreModal" class="hidden fixed inset-0 z-50">
    <div class="absolute inset-0 bg-black/50" onclick="closeSheet('moreModal')"></div>
    <div class="slide-up absolute bottom-0 left-0 right-0 bg-white rounded-t-3xl max-h-[75vh] flex flex-col">
        <div class="max-w-lg mx-auto w-full flex flex-col">
            <div class="p-4 border-b flex items-center justify-between shrink-0">
                <h3 class="text-base font-bold text-gray-900">About {{ $restaurant->name }}</h3>
                <button onclick="closeSheet('moreModal')" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="p-4 space-y-3">
                @if($restaurant->description)
                <p class="text-sm text-gray-600">{{ $restaurant->description }}</p>
                @endif
                <div class="space-y-2 text-sm">
                    @if($restaurant->address)
                    <div class="flex items-start gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span class="text-gray-700">{{ $restaurant->address }}</span>
                    </div>
                    @endif
                    @if($restaurant->phone)
                    <div class="flex items-center gap-2.5">
                        <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        <a href="tel:{{ $restaurant->phone }}" class="text-gray-700">{{ $restaurant->phone }}</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const CURRENCY = '{{ $restaurant->currency }}';
const TAX_RATE = {{ $restaurant->tax_rate }};
const SERVICE_RATE = {{ $restaurant->service_charge }};
const RESTAURANT_ID = {{ $restaurant->id }};
const TABLE_ID = {{ $table?->id ?? 'null' }};
const ACTIVE_ORDER_NUMBER = @json($activeOrder?->order_number);
let cart = {};

function nf(n) { return Math.round(n).toLocaleString(); }

/* ---- Quick Actions: Offers / Services / Pay Bills / More ----
 * Services (ordering) and Pay Bills both require the guest to have scanned
 * their table's QR code first, per house policy - so food is only ever
 * served to the table that actually ordered it. */
function promptScanTable(context) {
    Swal.fire({
        icon: 'info',
        title: 'Scan your table first',
        text: context === 'pay'
            ? 'To pay your bill, please scan the QR code on your table.'
            : 'To order, please scan the QR code on your table so we can serve you there.',
        confirmButtonColor: '#024938',
        confirmButtonText: 'Got it',
    });
}

function startServices() {
    if (!TABLE_ID) { promptScanTable('order'); return; }
    document.getElementById('menuArea')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
}

function openPayBills() {
    if (!TABLE_ID) { promptScanTable('pay'); return; }
    if (ACTIVE_ORDER_NUMBER) {
        window.location.href = '{{ url('/order') }}/' + ACTIVE_ORDER_NUMBER;
    } else {
        Swal.fire({
            icon: 'info',
            title: 'No open bill yet',
            text: 'Place an order first, then come back here to pay your bill.',
            confirmButtonColor: '#024938',
            confirmButtonText: 'Order Now',
        }).then(() => startServices());
    }
}

function openOffers() { document.getElementById('offersModal').classList.remove('hidden'); }
function openMore() { document.getElementById('moreModal').classList.remove('hidden'); }
function closeSheet(id) { document.getElementById(id).classList.add('hidden'); }

// Guard the actual "add to cart" action behind the same table-scan requirement.
function tryAddToCart(id, name, price) {
    if (!TABLE_ID) { promptScanTable('order'); return; }
    addToCart(id, name, price);
}

function addToCart(id, name, price) {
    if (!cart[id]) cart[id] = { id, name, price, qty: 0 };
    cart[id].qty++;
    renderControls(id);
    updateCartBar(true);
}

function decrementItem(id) {
    if (cart[id]) {
        cart[id].qty--;
        if (cart[id].qty <= 0) delete cart[id];
    }
    renderControls(id);
    updateCartBar();
    renderCartItems();
}

function renderControls(id) {
    const el = document.getElementById('ctrl-' + id);
    if (!el) return;
    const item = cart[id];
    if (item && item.qty > 0) {
        el.innerHTML = `
            <button onclick="decrementItem(${id})" class="w-8 h-8 rounded-full border-2 border-emerald-600 text-emerald-600 flex items-center justify-center active:scale-95 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
            </button>
            <span class="text-sm font-extrabold text-gray-900 w-5 text-center">${item.qty}</span>
            <button onclick="addToCart(${id}, '${item.name.replace(/'/g, "\\'")}', ${item.price})" class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center active:scale-95 transition-all">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            </button>`;
    } else {
        const name = document.querySelector(`#ctrl-${id}`);
        el.innerHTML = `
            <button onclick="addToCart(${id}, '', 0)" data-restore="${id}" class="w-9 h-9 rounded-full bg-emerald-600 text-white flex items-center justify-center hover:bg-emerald-700 active:scale-95 transition-all shadow-md restore-btn">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            </button>`;
        // restore original add with correct data
        location.reload = location.reload; // no-op
    }
}

// keep original item data for re-add after removal
const ITEM_DATA = {
    @foreach($categories as $category)
    @foreach($category->menuItems as $item)
    {{ $item->id }}: { name: '{{ addslashes($item->name) }}', price: {{ $item->price }} },
    @endforeach
    @endforeach
};

document.addEventListener('click', function(e) {
    const btn = e.target.closest('.restore-btn');
    if (btn) {
        const id = parseInt(btn.dataset.restore);
        const d = ITEM_DATA[id];
        if (d && (!cart[id] || cart[id].qty === 0)) {
            delete cart[id];
            addToCart(id, d.name, d.price);
        }
    }
});

function cartCount() { return Object.values(cart).reduce((s, i) => s + i.qty, 0); }
function cartSubtotal() { return Object.values(cart).reduce((s, i) => s + i.qty * i.price, 0); }

function updateCartBar(bounce = false) {
    const count = cartCount();
    const bar = document.getElementById('cartBar');
    const badge = document.getElementById('cartBadge');
    if (count > 0) {
        bar.classList.remove('hidden');
        badge.textContent = count;
        if (bounce) { badge.classList.remove('badge-bounce'); void badge.offsetWidth; badge.classList.add('badge-bounce'); }
        const sub = cartSubtotal();
        const total = sub + sub * TAX_RATE / 100 + sub * SERVICE_RATE / 100;
        document.getElementById('cartTotal').textContent = CURRENCY + ' ' + nf(total);
    } else {
        bar.classList.add('hidden');
        closeCart();
    }
}

function openCart() {
    renderCartItems();
    document.getElementById('cartDrawer').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeCart() {
    document.getElementById('cartDrawer').classList.add('hidden');
    document.body.style.overflow = '';
}

function renderCartItems() {
    const wrap = document.getElementById('cartItems');
    const items = Object.values(cart);
    if (items.length === 0) {
        wrap.innerHTML = '<p class="text-center text-gray-400 text-sm py-8">Your cart is empty</p>';
    } else {
        wrap.innerHTML = items.map(i => `
            <div class="flex items-center gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-bold text-gray-900">${i.name}</p>
                    <p class="text-xs text-gray-400">${CURRENCY} ${nf(i.price)} each</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <button onclick="decrementItem(${i.id})" class="w-7 h-7 rounded-full border-2 border-emerald-600 text-emerald-600 flex items-center justify-center">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M20 12H4"/></svg>
                    </button>
                    <span class="text-sm font-extrabold w-5 text-center">${i.qty}</span>
                    <button onclick="addToCart(${i.id}, '${i.name.replace(/'/g, "\\'")}', ${i.price}); renderCartItems(); updateSummary();" class="w-7 h-7 rounded-full bg-emerald-600 text-white flex items-center justify-center">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    </button>
                </div>
                <span class="text-sm font-extrabold text-gray-900 w-20 text-right shrink-0">${CURRENCY} ${nf(i.price * i.qty)}</span>
            </div>
        `).join('');
    }
    updateSummary();
}

function updateSummary() {
    const sub = cartSubtotal();
    const tax = sub * TAX_RATE / 100;
    const service = sub * SERVICE_RATE / 100;
    document.getElementById('sumSubtotal').textContent = CURRENCY + ' ' + nf(sub);
    document.getElementById('sumTax').textContent = CURRENCY + ' ' + nf(tax);
    const svcEl = document.getElementById('sumService');
    if (svcEl) svcEl.textContent = CURRENCY + ' ' + nf(service);
    document.getElementById('sumTotal').textContent = CURRENCY + ' ' + nf(sub + tax + service);
}

function filterCategory(cat, btn) {
    document.querySelectorAll('.cat-pill').forEach(p => p.classList.remove('active'));
    btn.classList.add('active');
    document.querySelectorAll('.menu-section').forEach(s => {
        s.style.display = (cat === 'all' || s.dataset.cat === cat) ? '' : 'none';
    });
}

async function placeOrder() {
    const items = Object.values(cart).map(i => ({ menu_item_id: i.id, quantity: i.qty }));
    if (items.length === 0) return;

    const btn = document.getElementById('placeBtn');
    btn.disabled = true;
    btn.textContent = 'Placing order...';

    try {
        const response = await fetch('{{ route('customer.order.place') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                restaurant_id: RESTAURANT_ID,
                table_id: TABLE_ID,
                customer_name: document.getElementById('custName').value.trim(),
                customer_phone: document.getElementById('custPhone').value.trim(),
                items: items,
            }),
        });
        const result = await response.json();
        if (result.success) {
            await Swal.fire({
                icon: 'success',
                title: 'Order Placed!',
                text: 'Your order ' + result.order_number + ' has been sent to the kitchen.',
                confirmButtonColor: '#024938',
                confirmButtonText: 'Track Order',
            });
            window.location.href = result.redirect;
        } else {
            throw new Error(result.message || 'Failed');
        }
    } catch (err) {
        btn.disabled = false;
        btn.textContent = 'Place Order';
        Swal.fire({ icon: 'error', title: 'Oops...', text: err.message || 'Something went wrong. Please try again.', confirmButtonColor: '#024938' });
    }
}
</script>

</body>
</html>
