<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Restora') - Order. Serve. Manage. Grow.</title>
    <meta name="description" content="Restora is a modern restaurant management system that helps you take orders, serve customers, manage inventory, and grow your business.">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon.png') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=2">
    <meta name="theme-color" content="#001816">

    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito:400,500,600,700,800,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
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
        html { scroll-behavior: smooth; }
        @keyframes fade-up { 0%{opacity:0;transform:translateY(30px)} 100%{opacity:1;transform:translateY(0)} }
        .animate-fade-up { animation: fade-up .8s ease-out both; }
        .delay-1 { animation-delay:.1s }
        .delay-2 { animation-delay:.3s }
        .delay-3 { animation-delay:.5s }
    </style>
</head>
<body class="font-['Nunito',sans-serif] antialiased bg-white text-slate-800">

{{-- ===================== HEADER ===================== --}}
<header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-md border-b border-gray-100 shadow-sm">
    <nav class="max-w-screen-xl 2xl:max-w-screen-2xl mx-auto px-4 lg:px-8 2xl:px-12">
        <div class="flex items-center justify-between h-[80px] lg:h-[88px] xl:h-[108px] 2xl:h-[118px]">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 flex-shrink-0">
                <img src="{{ asset('logo.png') }}?v=2" alt="Restora" class="h-[48px] lg:h-[56px] xl:h-[64px] 2xl:h-[72px] w-auto object-contain">
                <div>
                    <h1 class="text-xl lg:text-2xl xl:text-3xl font-extrabold text-emerald-900 tracking-tight leading-none">Restora</h1>
                    <p class="text-gold-600 text-[10px] lg:text-xs xl:text-sm font-medium leading-none mt-0.5">Order. Serve. Manage. Grow.</p>
                </div>
            </a>

            {{-- Desktop Nav --}}
            <div class="hidden md:flex items-center space-x-1">
                <a href="/" class="group flex items-center gap-1.5 px-3 py-2 xl:px-4 xl:py-2.5 text-[15px] xl:text-base font-semibold @yield('nav-home', 'text-gray-600 hover:text-gray-900') rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Home</span>
                </a>
                <a href="{{ route('features') }}" class="group flex items-center gap-1.5 px-3 py-2 xl:px-4 xl:py-2.5 text-[15px] xl:text-base font-semibold @yield('nav-features', 'text-gray-600 hover:text-gray-900') rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 14H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    <span>Features</span>
                </a>
                <a href="{{ route('how-it-works') }}" class="group flex items-center gap-1.5 px-3 py-2 xl:px-4 xl:py-2.5 text-[15px] xl:text-base font-semibold @yield('nav-how', 'text-gray-600 hover:text-gray-900') rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>How It Works</span>
                </a>
                <a href="{{ route('about') }}" class="group flex items-center gap-1.5 px-3 py-2 xl:px-4 xl:py-2.5 text-[15px] xl:text-base font-semibold @yield('nav-about', 'text-gray-600 hover:text-gray-900') rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>About</span>
                </a>
            </div>

            {{-- Right Actions --}}
            <div class="flex items-center space-x-2">
                @auth
                    <a href="{{ url('/home') }}" class="px-4 py-2 xl:px-6 xl:py-3 text-sm xl:text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-md shadow-sm hover:shadow-md transition-all duration-200">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="hidden sm:inline-flex items-center px-4 py-2 xl:px-5 xl:py-2.5 text-sm xl:text-base font-semibold text-gray-700 hover:text-emerald-600 transition-colors">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="px-4 py-2 xl:px-6 xl:py-3 text-sm xl:text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-md shadow-sm hover:shadow-md transition-all duration-200">
                        Get Started
                    </a>
                @endauth
                <button id="mobileMenuToggle" type="button" class="md:hidden p-2.5 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100 transition-colors ml-1">
                    <svg class="w-5 h-5" id="menu-open-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg class="w-5 h-5 hidden" id="menu-close-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="md:hidden hidden pb-4 border-t border-gray-100 mt-1" id="mobile-menu">
            <div class="pt-3 space-y-1">
                <a href="/" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Home
                </a>
                <a href="{{ route('features') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-gold-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 14H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    Features
                </a>
                <a href="{{ route('how-it-works') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    How It Works
                </a>
                <a href="{{ route('about') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg transition-colors">
                    <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    About
                </a>
                <div class="pt-2 border-t border-gray-100 flex items-center gap-2 px-1">
                    @auth
                        <a href="{{ url('/home') }}" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-xs font-semibold text-white bg-emerald-600 rounded-md hover:bg-emerald-700 transition-colors">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md hover:bg-emerald-100 transition-colors">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-xs font-semibold text-white bg-emerald-600 rounded-md hover:bg-emerald-700 transition-colors">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

{{-- Page Content --}}
<main class="pt-[80px] lg:pt-[88px] xl:pt-[108px] 2xl:pt-[118px]">
    @yield('content')
</main>

{{-- ===================== FOOTER ===================== --}}
<footer class="bg-emerald-900 text-emerald-100">
    <div class="max-w-screen-xl 2xl:max-w-screen-2xl mx-auto px-4 lg:px-8 2xl:px-12 py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 lg:gap-12">
            {{-- Brand --}}
            <div class="md:col-span-2">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ asset('logo.png') }}?v=2" alt="Restora" class="h-12 w-auto object-contain">
                    <div>
                        <h3 class="text-xl font-extrabold text-white">Restora</h3>
                        <p class="text-gold-300 text-sm">Order. Serve. Manage. Grow.</p>
                    </div>
                </div>
                <p class="text-emerald-200/70 text-sm max-w-md leading-relaxed">
                    Restora is the all-in-one restaurant management system designed to streamline your operations — from taking orders to managing inventory and growing your business.
                </p>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Quick Links</h4>
                <ul class="space-y-2.5">
                    <li><a href="/" class="text-emerald-200/70 hover:text-gold-300 transition-colors text-sm">Home</a></li>
                    <li><a href="{{ route('features') }}" class="text-emerald-200/70 hover:text-gold-300 transition-colors text-sm">Features</a></li>
                    <li><a href="{{ route('how-it-works') }}" class="text-emerald-200/70 hover:text-gold-300 transition-colors text-sm">How It Works</a></li>
                    <li><a href="{{ route('about') }}" class="text-emerald-200/70 hover:text-gold-300 transition-colors text-sm">About</a></li>
                </ul>
            </div>

            {{-- Auth Links --}}
            <div>
                <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Get Started</h4>
                <ul class="space-y-2.5">
                    @auth
                        <li><a href="{{ url('/home') }}" class="text-emerald-200/70 hover:text-gold-300 transition-colors text-sm">Dashboard</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-emerald-200/70 hover:text-gold-300 transition-colors text-sm">Log in</a></li>
                        <li><a href="{{ route('register') }}" class="text-emerald-200/70 hover:text-gold-300 transition-colors text-sm">Create Account</a></li>
                    @endauth
                </ul>
            </div>
        </div>

        <div class="border-t border-emerald-800 mt-10 pt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p class="text-emerald-300/60 text-xs">&copy; {{ date('Y') }} Restora. All rights reserved.</p>
            <p class="text-emerald-300/60 text-xs">Order. Serve. Manage. Grow.</p>
        </div>
    </div>
</footer>

{{-- ===================== SCRIPTS ===================== --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, easing: 'ease-in-out', once: true, offset: 100 });

// Mobile menu toggle
(function(){
    var t=document.getElementById('mobileMenuToggle'),
        m=document.getElementById('mobile-menu'),
        o=document.getElementById('menu-open-icon'),
        c=document.getElementById('menu-close-icon');
    if(t){
        t.addEventListener('click',function(){
            m.classList.toggle('hidden');
            o.classList.toggle('hidden');
            c.classList.toggle('hidden');
        });
    }
    if(m){
        m.querySelectorAll('a').forEach(function(l){
            l.addEventListener('click',function(){
                m.classList.add('hidden');
                o.classList.remove('hidden');
                c.classList.add('hidden');
            });
        });
    }
    // Navbar scroll effect
    var h=document.getElementById('main-header');
    if(h){
        window.addEventListener('scroll',function(){
            if(window.scrollY>10){
                h.classList.add('shadow-md');
                h.classList.remove('shadow-sm');
            }else{
                h.classList.remove('shadow-md');
                h.classList.add('shadow-sm');
            }
        },{passive:true});
    }
})();
</script>
</body>
</html>
