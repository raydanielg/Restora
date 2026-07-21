<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Restora'))</title>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2">
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        emerald: { 50:'#e6f5f1',100:'#b3e0d4',200:'#80cbc0',300:'#4db5a8',400:'#1a9f8e',500:'#024938',600:'#023d30',700:'#013028',800:'#01241f',900:'#001816' },
                        gold: { 50:'#fff5e0',100:'#ffe6b3',200:'#ffd680',300:'#ffc64d',400:'#ffb71a',500:'#f9ac00',600:'#d49700',700:'#b07c00',800:'#8c6100',900:'#684600' }
                    }
                }
            }
        }
    </script>
    <style>
        @keyframes fadeIn { from { opacity:0; transform:translateY(8px) } to { opacity:1; transform:translateY(0) } }
        .animate-fade { animation: fadeIn 0.3s ease-out both; }
        .sidebar-link { transition: all 0.2s ease; }
        .sidebar-link:hover { background: rgba(255,255,255,0.06); }
        .sidebar-link.active { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar-submenu { max-height: 0; overflow: hidden; transition: max-height 0.3s ease; }
        .sidebar-submenu.open { max-height: 500px; }
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #01241f; }
        ::-webkit-scrollbar-thumb { background: #024938; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #f9ac00; }
        .card-hover { transition: all 0.2s cubic-bezier(0.4,0,0.2,1); }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 30px -8px rgba(0,0,0,0.12); }
        @keyframes circleProgress { from { stroke-dashoffset: var(--circumference); } to { stroke-dashoffset: var(--offset); } }
        .circle-progress { animation: circleProgress 1.2s ease-out forwards; }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-gray-50 text-slate-800"
    data-flash-success="{{ session('success') }}"
    data-flash-error="{{ session('error') ?: $errors->first() }}">

    {{-- Mobile Overlay --}}
    <div id="mobileOverlay" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

    {{-- Sidebar --}}
    <aside id="dashboardSidebar" class="fixed top-0 left-0 z-50 w-64 h-screen bg-emerald-900 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 flex flex-col">
        {{-- Brand --}}
        <div class="h-16 flex items-center px-5 border-b border-emerald-800/50 flex-shrink-0">
            <img src="{{ asset('logo.png') }}?v=2" alt="Restora" class="h-9 w-auto object-contain">
            <div class="ml-2.5">
                <span class="text-white font-bold text-sm tracking-wide leading-none block">RESTORA</span>
                <span class="text-gold-400 text-[9px] font-medium tracking-wide">Admin Panel</span>
            </div>
        </div>

        {{-- Menu --}}
        <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            @php $userRole = Auth::user()->role ?? 'owner'; @endphp

            @if($userRole === 'chef')
            {{-- Chef Menu --}}
            <a href="{{ route('kitchen.index') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('kitchen.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>Kitchen Queue</span>
            </a>
            @elseif($userRole === 'waiter')
            {{-- Waiter Menu --}}
            <a href="{{ route('waiter.index') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('waiter.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>My Dashboard</span>
            </a>
            <a href="{{ route('orders.create') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('orders.create') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>New Order</span>
            </a>
            @elseif($userRole === 'reception')
            {{-- Reception Menu --}}
            <a href="{{ route('reception.index') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('reception.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Reception</span>
            </a>
            <a href="{{ route('orders.index') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>All Orders</span>
            </a>
            <a href="{{ route('orders.create') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('orders.create') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>New Order</span>
            </a>
            @else
            {{-- Owner/Manager Menu --}}
            {{-- Dashboard --}}
            <a href="{{ route('home') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span>Dashboard</span>
            </a>

            {{-- Orders --}}
            <div class="sidebar-group">
                <button onclick="toggleMenu('menu-orders')" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('orders.*') ? 'active' : '' }}">
                    <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    <span>Orders</span>
                    <svg class="w-4 h-4 ml-auto transition-transform" id="arrow-orders" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div id="menu-orders" class="sidebar-submenu pl-11 space-y-0.5 {{ request()->routeIs('orders.*') ? 'open' : '' }}">
                    <a href="{{ route('orders.index') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('orders.index') ? 'text-white font-medium' : '' }}">All Orders</a>
                    <a href="{{ route('orders.create') }}" class="block py-1.5 text-xs text-emerald-200/70 hover:text-white transition-colors {{ request()->routeIs('orders.create') ? 'text-white font-medium' : '' }}">New Order</a>
                </div>
            </div>

            {{-- Menu Management --}}
            <a href="{{ route('menu.index') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('menu.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span>Menu</span>
            </a>

            {{-- Tables --}}
            <a href="{{ route('tables.index') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('tables.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6M9 14h6"/></svg>
                <span>Tables</span>
            </a>

            {{-- Staff --}}
            <a href="{{ route('staff.index') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('staff.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Staff</span>
            </a>

            {{-- Reports --}}
            <a href="{{ route('reports.index') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>Reports</span>
            </a>

            {{-- Settings (owner only) --}}
            @if($userRole === 'owner')
            <a href="{{ route('settings.index') }}" class="sidebar-link w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-emerald-100 text-sm font-medium {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <svg class="w-5 h-5 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Settings</span>
            </a>
            @endif
            @endif
        </div>

        {{-- Bottom User --}}
        <div class="p-4 border-t border-emerald-800/50">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-gold-400 to-gold-600 flex items-center justify-center text-white font-bold text-xs">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-emerald-300/60">{{ ucfirst(Auth::user()->role ?? 'Admin') }}</p>
                </div>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('dashboard-logout').submit();" class="text-emerald-300/60 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </a>
                <form id="dashboard-logout" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="lg:ml-64 min-h-screen flex flex-col">

        {{-- Header --}}
        <header class="h-16 bg-white border-b border-gray-100 flex items-center justify-between px-4 sm:px-6 sticky top-0 z-30">
            <div class="flex items-center gap-3">
                <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <h1 class="text-base sm:text-lg font-bold text-gray-800">@yield('page_title', 'Dashboard')</h1>
            </div>
            <div class="flex items-center gap-3 sm:gap-4">
                {{-- Search --}}
                <div class="hidden md:flex items-center bg-gray-50 rounded-lg px-3 py-1.5 border border-gray-100">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" placeholder="Search..." class="bg-transparent text-sm outline-none w-40 lg:w-48 text-gray-600 placeholder-gray-400">
                </div>
                {{-- Notifications --}}
                <div id="notifBell" class="relative">
                    <button onclick="document.getElementById('notifDropdown').classList.toggle('hidden')" class="relative p-2 rounded-lg hover:bg-gray-100 text-gray-500 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                        @if(count($liveNotifications ?? []) > 0)
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                        @endif
                    </button>
                    <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-72 sm:w-80 bg-white rounded-xl border border-gray-100 shadow-xl z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b bg-gray-50/50">
                            <p class="text-sm font-bold text-gray-800">Notifications</p>
                        </div>
                        <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                            @forelse($liveNotifications ?? [] as $n)
                            <a href="{{ $n['url'] }}" class="block px-4 py-3 hover:bg-gray-50 transition-colors">
                                <p class="text-xs font-medium text-gray-800">{{ $n['text'] }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $n['time'] }}</p>
                            </a>
                            @empty
                            <p class="px-4 py-8 text-center text-xs text-gray-400">You're all caught up.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-4 sm:p-6 animate-fade">
            @yield('content')
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('dashboardSidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        function toggleMenu(id) {
            const menu = document.getElementById(id);
            const arrow = document.getElementById('arrow-' + id.replace('menu-', ''));
            menu.classList.toggle('open');
            if (arrow) arrow.classList.toggle('rotate-180');
        }

        /* ============================================================
         * Restora OS — shared AJAX + centered toast layer
         * Every dashboard form/action reuses this instead of hard page
         * reloads. It works by intercepting form submits & action clicks,
         * sending them over fetch(), then swapping <main> with the fresh
         * server-rendered content from the (possibly redirected) response
         * — so every list/badge/table stays in sync with the database
         * without a full browser navigation or white-flash reload.
         * ============================================================ */

        // Small, centered toast (replaces the old top-right SweetAlert toast).
        // Messages carrying a one-time code (e.g. a new staff login code) stay on
        // screen until dismissed instead of auto-vanishing after a couple seconds.
        function restoraToast(icon, message) {
            if (!message) return;
            const mustCopy = /login code:/i.test(message);
            Swal.fire({
                icon: icon,
                title: mustCopy ? 'Staff Added' : message,
                text: mustCopy ? message : undefined,
                position: 'center',
                toast: false,
                showConfirmButton: mustCopy,
                confirmButtonColor: '#024938',
                timer: mustCopy ? undefined : 2600,
                timerProgressBar: !mustCopy,
                width: 'auto',
                customClass: { popup: 'restora-toast-popup' },
            });
        }

        function restoraConfirm(title, text) {
            return Swal.fire({
                title: title || 'Are you sure?',
                text: text || "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#024938',
                cancelButtonColor: '#dc2626',
                confirmButtonText: 'Yes, proceed!',
                cancelButtonText: 'Cancel',
            });
        }

        // Legacy helper name kept for compatibility with any inline callers.
        function confirmAction(formId, title, text) {
            restoraConfirm(title, text).then((result) => {
                if (result.isConfirmed) document.getElementById(formId).submit();
            });
        }

        function csrfToken() {
            return document.querySelector('meta[name="csrf-token"]').content;
        }

        function showFlashFromDocument(doc) {
            const body = doc.body || doc;
            const success = body.dataset ? body.dataset.flashSuccess : null;
            const error = body.dataset ? body.dataset.flashError : null;
            if (success) restoraToast('success', success);
            if (error) restoraToast('error', error);
        }

        // Also refresh the notification bell (new orders / ready meals / cash handovers)
        // whenever we have a fresh copy of the page, since it's cheap and keeps staff informed.
        function syncNotifBell(doc) {
            const newBell = doc.querySelector('#notifBell');
            const curBell = document.querySelector('#notifBell');
            if (newBell && curBell) curBell.innerHTML = newBell.innerHTML;
        }

        // Swap <main> with the main content of a freshly fetched HTML page,
        // without a full browser navigation (no reload flash, keeps sidebar state).
        function swapMainFromHtml(html) {
            const doc = new DOMParser().parseFromString(html, 'text/html');
            const newMain = doc.querySelector('main');
            const currentMain = document.querySelector('main');
            if (newMain && currentMain) {
                currentMain.innerHTML = newMain.innerHTML;
                syncNotifBell(doc);
                showFlashFromDocument(doc);
            } else {
                // Response wasn't a normal dashboard page (e.g. a 403/500 error page) -
                // fall back to a generic toast instead of silently doing nothing.
                restoraToast('error', 'Something went wrong. Please refresh and try again.');
            }
        }

        async function refreshMain() {
            try {
                // Note: deliberately not sending X-Requested-With here - Laravel treats that
                // header (combined with a generic Accept) as "wants JSON" for validation errors,
                // which would break our HTML-based main-swap. Plain GET keeps normal HTML back.
                const res = await fetch(window.location.href);
                const html = await res.text();
                const doc = new DOMParser().parseFromString(html, 'text/html');
                const newMain = doc.querySelector('main');
                const currentMain = document.querySelector('main');
                if (newMain && currentMain) currentMain.innerHTML = newMain.innerHTML;
                syncNotifBell(doc);
            } catch (e) { /* silent - keep last known state on network hiccup */ }
        }

        // Close the notification dropdown when clicking outside of it.
        document.addEventListener('click', function(e) {
            const bell = document.getElementById('notifBell');
            const dropdown = document.getElementById('notifDropdown');
            if (bell && dropdown && !bell.contains(e.target)) dropdown.classList.add('hidden');
        });

        // Auto-refresh helper for live boards (kitchen/waiter/reception). Skips the
        // refresh while the user is actively typing/selecting inside the page.
        function startLiveRefresh(intervalMs) {
            setInterval(() => {
                const active = document.activeElement;
                const main = document.querySelector('main');
                const isTypingInMain = active && main && main.contains(active) && ['INPUT', 'SELECT', 'TEXTAREA'].includes(active.tagName);
                const modalOpen = document.querySelector('main [id^="modal-"]:not(.hidden)');
                if (!isTypingInMain && !modalOpen) refreshMain();
            }, intervalMs);
        }

        // Show flash messages from the page that was just loaded normally (first load / full navigation).
        document.addEventListener('DOMContentLoaded', function() {
            showFlashFromDocument(document);
        });

        // Intercept every form marked data-ajax and submit it over fetch().
        document.addEventListener('submit', async function(e) {
            const form = e.target.closest('form[data-ajax]');
            if (!form) return;
            e.preventDefault();

            if (form.dataset.confirm) {
                const result = await restoraConfirm(form.dataset.confirm, form.dataset.confirmText || '');
                if (!result.isConfirmed) return;
            }

            const submitBtn = form.querySelector('[type="submit"]');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : null;
            if (submitBtn) { submitBtn.disabled = true; submitBtn.dataset.loading = '1'; }

            try {
                // Deliberately not sending X-Requested-With: Laravel would treat that as
                // "wants JSON" on validation failure and return a 422 JSON body instead of
                // the redirected HTML page our swap logic parses.
                const res = await fetch(form.action, {
                    method: 'POST', // Laravel spoofs PATCH/DELETE from the form's _method field
                    headers: { 'X-CSRF-TOKEN': csrfToken() },
                    body: new FormData(form),
                });
                const html = await res.text();

                if (res.ok) {
                    swapMainFromHtml(html);
                    if (form.dataset.resetOnSuccess !== 'false') form.reset();
                } else {
                    // Validation errors (422) etc. - the redirected-back page carries the error flash.
                    swapMainFromHtml(html);
                }
            } catch (err) {
                restoraToast('error', 'Network error — please try again.');
            } finally {
                if (submitBtn) { submitBtn.disabled = false; submitBtn.dataset.loading = ''; if (originalBtnHtml) submitBtn.innerHTML = originalBtnHtml; }
            }
        });
    </script>
    <style>
        .restora-toast-popup { border-radius: 14px !important; }
    </style>
    @stack('scripts')
</body>
</html>
