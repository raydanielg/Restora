@extends('layouts.dashboard')

@section('title', 'Staff - Restora')
@section('page_title', 'Staff Management')

@section('content')
<div class="mb-6 flex items-center justify-between flex-wrap gap-3">
    <div>
        <h2 class="text-lg font-bold text-gray-900">Staff Management</h2>
        <p class="text-sm text-gray-500">Manage your restaurant employees and their login codes</p>
    </div>
    <button onclick="document.getElementById('modal-staff').classList.remove('hidden')" class="px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">+ Add Staff</button>
</div>

<div class="bg-white rounded-xl border overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="text-left text-xs text-gray-500 bg-gray-50/50">
                    <th class="px-5 py-3 font-medium">Name</th>
                    <th class="px-5 py-3 font-medium">Role</th>
                    <th class="px-5 py-3 font-medium">Phone</th>
                    <th class="px-5 py-3 font-medium">Staff Code</th>
                    <th class="px-5 py-3 font-medium">Joined</th>
                    <th class="px-5 py-3 font-medium">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $member)
                <tr class="border-t border-gray-100 hover:bg-gray-50/50 transition-colors">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <span class="text-sm font-medium text-gray-900">{{ $member->name }}</span>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        @php
                            $roleColors = [
                                'manager' => 'bg-violet-50 text-violet-700 border-violet-200',
                                'reception' => 'bg-sky-50 text-sky-700 border-sky-200',
                                'waiter' => 'bg-amber-50 text-amber-700 border-amber-200',
                                'chef' => 'bg-red-50 text-red-700 border-red-200',
                            ];
                        @endphp
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-medium border {{ $roleColors[$member->role] ?? '' }}">
                            {{ ucfirst($member->role) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-700">{{ $member->phone ?? 'N/A' }}</td>
                    <td class="px-5 py-3">
                        <code class="text-xs font-mono font-bold text-gold-600 bg-gold-50 px-2 py-0.5 rounded">{{ $member->staff_code }}</code>
                    </td>
                    <td class="px-5 py-3 text-xs text-gray-400">{{ $member->created_at->format('M d, Y') }}</td>
                    <td class="px-5 py-3">
                        <form data-ajax data-confirm="Remove staff?" data-confirm-text="This will remove {{ addslashes($member->name) }} from your staff." action="{{ route('staff.destroy', $member) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-400 hover:text-red-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3"/></svg>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-5 py-12 text-center text-gray-400">
                        <p class="text-sm font-medium">No staff members yet</p>
                        <p class="text-xs mt-1">Add your first staff member to get started</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Modal: Add Staff --}}
<div id="modal-staff" class="hidden fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Add Staff Member</h3>
        <form data-ajax action="{{ route('staff.store') }}" method="POST">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                    <input type="text" name="name" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="John Mwangaza">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                    <input type="text" name="phone" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm" placeholder="0712 345 678">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" required class="w-full px-3 py-2 rounded-lg border border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-200 outline-none text-sm">
                        <option value="manager">Manager</option>
                        <option value="reception">Reception / Cashier</option>
                        <option value="waiter">Waiter</option>
                        <option value="chef">Chef / Kitchen Staff</option>
                    </select>
                </div>
                <div class="p-3 rounded-lg bg-amber-50 border border-amber-200 text-xs text-amber-700">
                    <p class="font-medium">A unique 6-digit login code will be generated automatically.</p>
                    <p class="mt-1">The staff member can use this code to log in without an email.</p>
                </div>
            </div>
            <div class="flex gap-3 mt-6">
                <button type="button" onclick="document.getElementById('modal-staff').classList.add('hidden')" class="flex-1 px-4 py-2 text-sm font-medium border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Cancel</button>
                <button type="submit" class="flex-1 px-4 py-2 text-sm font-medium bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Add Staff</button>
            </div>
        </form>
    </div>
</div>
@endsection
