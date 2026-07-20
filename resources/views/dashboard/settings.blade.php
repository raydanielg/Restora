@extends('layouts.dashboard')

@section('title', 'Settings - Restora')
@section('page_title', 'Restaurant Settings')

@section('content')

{{-- Restaurant Public Link --}}
<div class="bg-gradient-to-br from-emerald-700 to-emerald-900 rounded-xl border border-emerald-600 p-5 mb-6 text-white">
    <div class="flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="flex-1">
            <h3 class="text-sm font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                Your Restaurant Link
            </h3>
            <p class="text-xs text-emerald-200 mt-1">Share this link so customers can view your menu & order online</p>
            <div class="mt-3 flex items-center gap-2 bg-white/10 border border-white/20 rounded-lg px-3 py-2">
                <span id="restLink" class="text-xs font-mono text-gold-200 truncate flex-1">{{ url('/r/' . $restaurant->slug) }}</span>
                <button onclick="copyLink()" class="shrink-0 px-2.5 py-1 text-[10px] font-bold bg-gold-500 text-emerald-900 rounded-md hover:bg-gold-400 transition-colors">COPY</button>
            </div>
        </div>
        <div class="shrink-0 text-center">
            <div id="restQR" class="bg-white p-2 rounded-lg inline-block"></div>
            <button onclick="printRestaurantQR()" class="block w-full mt-2 text-[10px] font-bold text-gold-300 hover:text-gold-200 underline">Print QR</button>
        </div>
    </div>
</div>

<form action="{{ route('settings.update') }}" method="POST">
    @csrf
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Restaurant Info --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Restaurant Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Restaurant Name</label>
                    <input type="text" name="name" value="{{ $restaurant->name }}" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                        <select name="type" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                            @foreach(['restaurant' => 'Restaurant', 'cafe' => 'Cafe', 'bar' => 'Bar', 'fast_food' => 'Fast Food'] as $val => $label)
                            <option value="{{ $val }}" {{ $restaurant->type === $val ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Currency</label>
                        <input type="text" name="currency" value="{{ $restaurant->currency }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">{{ $restaurant->description }}</textarea>
                </div>
            </div>
        </div>

        {{-- Contact Info --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Contact & Location</h3>
            <div class="space-y-4">
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                        <input type="text" name="phone" value="{{ $restaurant->phone }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" value="{{ $restaurant->email }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" value="{{ $restaurant->address }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input type="text" name="location" value="{{ $restaurant->location }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm" placeholder="e.g. Dar es Salaam">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">TIN Number</label>
                    <input type="text" name="tin_number" value="{{ $restaurant->tin_number }}" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                </div>
            </div>
        </div>

        {{-- Financial Settings --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Financial Settings</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tax Rate (%)</label>
                    <input type="number" name="tax_rate" value="{{ $restaurant->tax_rate }}" step="0.01" min="0" max="100" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Service Charge (%)</label>
                    <input type="number" name="service_charge" value="{{ $restaurant->service_charge }}" step="0.01" min="0" max="100" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 outline-none text-sm">
                </div>
            </div>
        </div>

        {{-- Status --}}
        <div class="bg-white rounded-xl border p-5">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Account Status</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 rounded-lg border {{ $restaurant->status === 'approved' ? 'bg-emerald-50 border-emerald-200' : 'bg-amber-50 border-amber-200' }}">
                    <div>
                        <p class="text-sm font-medium text-gray-900">Verification Status</p>
                        <p class="text-xs text-gray-500">{{ ucfirst($restaurant->status) }}</p>
                    </div>
                    <span class="w-3 h-3 rounded-full {{ $restaurant->status === 'approved' ? 'bg-emerald-500' : 'bg-amber-500' }} animate-pulse"></span>
                </div>
                <div class="p-3 rounded-lg bg-gray-50 border border-gray-200">
                    <p class="text-xs text-gray-500">Your restaurant ID: <span class="font-mono font-medium text-gray-700">#{{ $restaurant->id }}</span></p>
                    <p class="text-xs text-gray-500 mt-1">Member since: <span class="font-medium text-gray-700">{{ $restaurant->created_at->format('M d, Y') }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button type="submit" class="px-6 py-2.5 text-sm font-bold bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">Save Changes</button>
    </div>
</form>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
const REST_LINK = '{{ url('/r/' . $restaurant->slug) }}';

new QRCode(document.getElementById('restQR'), {
    text: REST_LINK,
    width: 110,
    height: 110,
    colorDark: '#024938',
    colorLight: '#ffffff',
    correctLevel: QRCode.CorrectLevel.H
});

function copyLink() {
    navigator.clipboard.writeText(REST_LINK).then(() => {
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Link copied!', showConfirmButton: false, timer: 2000 });
    });
}

function printRestaurantQR() {
    const qrImg = document.querySelector('#restQR img') || document.querySelector('#restQR canvas');
    const imgSrc = qrImg.tagName === 'IMG' ? qrImg.src : qrImg.toDataURL();
    const win = window.open('', '_blank');
    win.document.write(`
        <html>
        <head><title>{{ addslashes($restaurant->name) }} - QR Code</title>
        <style>
            body { font-family: sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
            .card { text-align: center; padding: 40px; border: 3px solid #024938; border-radius: 20px; }
            h1 { color: #024938; margin: 0 0 4px; font-size: 26px; }
            p { color: #888; margin: 0 0 20px; font-size: 13px; }
            img { width: 280px; height: 280px; }
            .footer { margin-top: 20px; font-size: 12px; color: #024938; font-weight: bold; }
        </style>
        </head>
        <body>
            <div class="card">
                <h1>{{ addslashes($restaurant->name) }}</h1>
                <p>Scan to view our menu & order online</p>
                <img src="${imgSrc}">
                <div class="footer">Powered by Restora OS</div>
            </div>
            <script>window.onload = () => window.print();<\/script>
        </body>
        </html>
    `);
    win.document.close();
}
</script>
@endpush
@endsection
