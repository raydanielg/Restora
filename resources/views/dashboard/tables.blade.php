@extends('layouts.dashboard')

@section('title', 'Tables - Restora')
@section('page_title', 'Table Management')

@section('content')
<div class="mb-6 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="text-lg font-bold text-gray-900">Table Management</h2>
        <p class="text-sm text-gray-500">Manage your restaurant tables and QR codes</p>
    </div>
    <button onclick="document.getElementById('modal-table').classList.remove('hidden')" class="px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">+ Add Table</button>
</div>

<div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
    @foreach($tables as $table)
    <div class="bg-white rounded-xl border p-4 card-hover">
        <div class="flex items-center justify-between mb-3">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center font-bold text-sm
                {{ $table->status === 'available' ? 'bg-emerald-100 text-emerald-700' : '' }}
                {{ $table->status === 'occupied' ? 'bg-red-100 text-red-700' : '' }}
                {{ $table->status === 'reserved' ? 'bg-amber-100 text-amber-700' : '' }}">
                {{ strtoupper(substr($table->table_number, 0, 2)) }}
            </div>
            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full
                {{ $table->status === 'available' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                {{ $table->status === 'occupied' ? 'bg-red-50 text-red-700 border border-red-200' : '' }}
                {{ $table->status === 'reserved' ? 'bg-amber-50 text-amber-700 border border-amber-200' : '' }}">
                {{ ucfirst($table->status) }}
            </span>
        </div>
        <p class="text-sm font-bold text-gray-900">{{ $table->table_number }}</p>
        <p class="text-xs text-gray-400">{{ $table->capacity }} seats &middot; {{ $table->section ?? 'indoor' }}</p>
        @if($table->activeOrder)
        <div class="mt-2 pt-2 border-t border-gray-100">
            <p class="text-[10px] text-gray-500">Active: <span class="font-mono font-medium text-gray-700">{{ $table->activeOrder->order_number }}</span></p>
        </div>
        @endif
        <div class="mt-3">
            <button onclick="showQR('{{ $table->qr_code }}', '{{ addslashes($table->table_number) }}')" class="w-full py-1.5 text-[11px] font-bold text-emerald-700 border border-emerald-200 bg-emerald-50 rounded-lg hover:bg-emerald-100 transition-colors inline-flex items-center justify-center gap-1.5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                View QR Code
            </button>
        </div>
        <div class="mt-2 flex items-center gap-2">
            <form data-ajax data-reset-on-success="false" action="{{ route('tables.status', $table) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" onchange="this.form.requestSubmit()" class="text-[10px] border border-gray-200 rounded-md px-1.5 py-1 outline-none focus:border-emerald-500">
                    <option value="available" {{ $table->status === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ $table->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="reserved" {{ $table->status === 'reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
            </form>
            <form data-ajax data-confirm="Delete table?" data-confirm-text="This will remove the table from your restaurant." action="{{ route('tables.destroy', $table) }}" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-600 ml-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>

@if($tables->isEmpty())
<div class="bg-white rounded-xl border p-12 text-center">
    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 10h6M9 14h6"/></svg>
    <p class="text-gray-500 font-medium">No tables yet</p>
    <p class="text-gray-400 text-sm mt-1">Add your first table to get started</p>
</div>
@endif

{{-- Modal: QR Code --}}
<div id="modal-qr" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-sm w-full p-6 text-center">
        <h3 class="text-lg font-bold text-gray-900" id="qr-title">Table QR</h3>
        <p class="text-xs text-gray-400 mb-4">Customers scan this to view menu & order</p>
        <div id="qr-container" class="flex justify-center p-4 bg-white rounded-lg border-2 border-dashed border-gray-200 mx-auto" style="width: fit-content;"></div>
        <p class="text-[10px] text-gray-400 mt-3 break-all" id="qr-link"></p>
        <div class="flex gap-3 mt-5">
            <button onclick="document.getElementById('modal-qr').classList.add('hidden')" class="flex-1 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Close</button>
            <button onclick="printQR()" class="flex-1 px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 inline-flex items-center justify-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print
            </button>
        </div>
    </div>
</div>

{{-- Modal: Add Table --}}
<div id="modal-table" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Add Table</h3>
        <form data-ajax action="{{ route('tables.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Table Number / Name</label>
                    <input type="text" name="table_number" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="e.g. Table 01 or VIP Table">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Section</label>
                        <select name="section" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm">
                            <option value="indoor">Indoor</option>
                            <option value="outdoor">Outdoor</option>
                            <option value="vip">VIP</option>
                            <option value="bar">Bar</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                        <input type="number" name="capacity" min="1" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="4" value="4">
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modal-table').classList.add('hidden')" class="flex-1 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Create</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
<script>
let currentQRUrl = '';
let currentQRTitle = '';

function showQR(qrCode, tableName) {
    currentQRUrl = '{{ url('/table') }}/' + qrCode;
    currentQRTitle = tableName;
    document.getElementById('qr-title').textContent = tableName + ' - QR Code';
    document.getElementById('qr-link').textContent = currentQRUrl;
    const container = document.getElementById('qr-container');
    container.innerHTML = '';
    new QRCode(container, {
        text: currentQRUrl,
        width: 200,
        height: 200,
        colorDark: '#024938',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });
    document.getElementById('modal-qr').classList.remove('hidden');
}

function printQR() {
    const qrImg = document.querySelector('#qr-container img') || document.querySelector('#qr-container canvas');
    const imgSrc = qrImg.tagName === 'IMG' ? qrImg.src : qrImg.toDataURL();
    const win = window.open('', '_blank');
    win.document.write(`
        <html>
        <head><title>${currentQRTitle} - QR Code</title>
        <style>
            body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; min-height: 100vh; margin: 0; }
            .card { text-align: center; padding: 40px; border: 3px solid #024938; border-radius: 20px; }
            h1 { color: #024938; margin: 0 0 4px; font-size: 28px; }
            p { color: #888; margin: 0 0 20px; font-size: 13px; }
            img { width: 280px; height: 280px; }
            .footer { margin-top: 20px; font-size: 12px; color: #024938; font-weight: bold; }
        </style>
        </head>
        <body>
            <div class="card">
                <h1>${currentQRTitle}</h1>
                <p>Scan to view menu & place your order</p>
                <img src="${imgSrc}">
                <div class="footer">Powered by Restora OS</div>
            </div>
            <script>window.onload = () => { window.print(); }<\/script>
        </body>
        </html>
    `);
    win.document.close();
}
</script>
@endpush
@endsection
