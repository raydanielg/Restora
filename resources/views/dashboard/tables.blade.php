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
        <div class="mt-3 flex items-center gap-2">
            <form action="{{ route('tables.status', $table) }}" method="POST">
                @csrf @method('PATCH')
                <select name="status" onchange="this.form.submit()" class="text-[10px] border border-gray-200 rounded-md px-1.5 py-1 outline-none focus:border-emerald-500">
                    <option value="available" {{ $table->status === 'available' ? 'selected' : '' }}>Available</option>
                    <option value="occupied" {{ $table->status === 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="reserved" {{ $table->status === 'reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
            </form>
            <form id="del-table-{{ $table->id }}" action="{{ route('tables.destroy', $table) }}" method="POST">
                @csrf @method('DELETE')
                <button type="button" onclick="confirmAction('del-table-{{ $table->id }}', 'Delete table?', 'This will remove the table from your restaurant.')" class="text-red-400 hover:text-red-600 ml-auto">
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

{{-- Modal: Add Table --}}
<div id="modal-table" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Add Table</h3>
        <form action="{{ route('tables.store') }}" method="POST">
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
@endsection
