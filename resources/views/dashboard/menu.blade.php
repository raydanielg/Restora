@extends('layouts.dashboard')

@section('title', 'Menu Management - Restora')
@section('page_title', 'Menu Management')

@section('content')
<div class="mb-6 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="text-lg font-bold text-gray-900">Menu Management</h2>
        <p class="text-sm text-gray-500">Manage your categories and food items</p>
    </div>
    <div class="flex gap-2">
        <button onclick="document.getElementById('modal-category').classList.remove('hidden')" class="px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">+ Add Category</button>
        <button onclick="document.getElementById('modal-item').classList.remove('hidden')" class="px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">+ Add Menu Item</button>
    </div>
</div>

<div class="space-y-6">
    @foreach($categories as $category)
    <div class="bg-white rounded-xl border overflow-hidden">
        <div class="px-5 py-4 border-b flex items-center justify-between bg-gray-50/50">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 flex items-center justify-center">
                    @if($category->icon)
                    <i class="{{ $category->icon }} text-emerald-600"></i>
                    @else
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    @endif
                </div>
                <div>
                    <h3 class="text-sm font-bold text-gray-900">{{ $category->name }}</h3>
                    <p class="text-xs text-gray-400">{{ $category->menuItems->count() }} items</p>
                </div>
            </div>
            <form id="del-cat-{{ $category->id }}" action="{{ route('menu.categories.destroy', $category) }}" method="POST">
                @csrf @method('DELETE')
                <button type="button" onclick="confirmAction('del-cat-{{ $category->id }}', 'Delete category?', 'This will delete the category and all its menu items.')" class="text-red-500 hover:text-red-700 text-xs font-medium">Delete</button>
            </form>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($category->menuItems as $item)
            <div class="flex items-center gap-4 px-5 py-3 hover:bg-gray-50/50 transition-colors">
                <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center shrink-0">
                    @if($item->image)
                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover rounded-lg">
                    @else
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900">{{ $item->name }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ $item->description ?? 'No description' }}</p>
                </div>
                <div class="text-right shrink-0">
                    <p class="text-sm font-bold text-gray-900">TSh {{ number_format($item->price) }}</p>
                    <p class="text-[10px] text-gray-400">{{ $item->preparation_time }} min</p>
                </div>
                <div class="flex items-center gap-2 shrink-0">
                    <form action="{{ route('menu.items.toggle', $item) }}" method="POST">
                        @csrf @method('PATCH')
                        <button class="text-xs font-medium px-2.5 py-1 rounded-full {{ $item->is_available ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-red-50 text-red-700 border border-red-200' }}">
                            {{ $item->is_available ? 'Available' : 'Unavailable' }}
                        </button>
                    </form>
                    <form id="del-item-{{ $item->id }}" action="{{ route('menu.items.destroy', $item) }}" method="POST">
                        @csrf @method('DELETE')
                        <button type="button" onclick="confirmAction('del-item-{{ $item->id }}', 'Delete item?', 'This will remove {{ $item->name }} from your menu.')" class="text-red-400 hover:text-red-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @empty
            <div class="px-5 py-8 text-center text-gray-400 text-sm">No items in this category yet</div>
            @endforelse
        </div>
    </div>
    @endforeach
    @if($categories->isEmpty())
    <div class="bg-white rounded-xl border p-12 text-center">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        <p class="text-gray-500 font-medium">No categories yet</p>
        <p class="text-gray-400 text-sm mt-1">Create your first category to start adding menu items</p>
    </div>
    @endif
</div>

{{-- Modal: Add Category --}}
<div id="modal-category" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Add Category</h3>
        <form action="{{ route('menu.categories.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category Name</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="e.g. Breakfast">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon (Font Awesome class)</label>
                    <input type="text" name="icon" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="fas fa-utensils">
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modal-category').classList.add('hidden')" class="flex-1 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Create</button>
            </div>
        </form>
    </div>
</div>

{{-- Modal: Add Menu Item --}}
<div id="modal-item" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6 max-h-[90vh] overflow-y-auto">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Add Menu Item</h3>
        <form action="{{ route('menu.items.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category_id" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm">
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="e.g. Beef Burger">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="Short description..."></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Price (TSh)</label>
                        <input type="number" name="price" required min="0" step="100" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="15000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prep Time (min)</label>
                        <input type="number" name="preparation_time" min="1" class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="15" value="15">
                    </div>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modal-item').classList.add('hidden')" class="flex-1 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Add Item</button>
            </div>
        </form>
    </div>
</div>
@endsection
