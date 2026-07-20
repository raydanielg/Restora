<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restora - Order. Serve. Manage. Grow.</title>
    <meta name="description" content="Restora is a modern restaurant management system that helps you take orders, serve customers, manage inventory, and grow your business.">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}?v=2">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon.png') }}?v=2">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('favicon.png') }}?v=2">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}?v=2">
    <meta name="theme-color" content="#001816">
    <meta property="og:title" content="Restora">
    <meta property="og:description" content="Order. Serve. Manage. Grow.">
    <meta property="og:image" content="{{ asset('favicon.png') }}">
    <meta property="og:type" content="website">

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
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-15px)} }
        .animate-float { animation: float 6s ease-in-out infinite; }
        @keyframes fade-up { 0%{opacity:0;transform:translateY(30px)} 100%{opacity:1;transform:translateY(0)} }
        .animate-fade-up { animation: fade-up .8s ease-out both; }
        .delay-1 { animation-delay:.1s }
        .delay-2 { animation-delay:.3s }
        .delay-3 { animation-delay:.5s }
        .delay-4 { animation-delay:.7s }
        .delay-5 { animation-delay:.9s }
        @keyframes pulse-ring { 0%{transform:scale(.8);opacity:1} 100%{transform:scale(1.4);opacity:0} }
        .pulse-ring { animation: pulse-ring 2s ease-out infinite; }
        @keyframes flow-h { 0%{transform:translateX(-10%)} 100%{transform:translateX(10%)} }
        .flow-line-h { animation: flow-h 8s linear infinite; }
        .flow-line-h.delay-1 { animation-delay:-2s }
        .flow-line-h.delay-2 { animation-delay:-4s }
        .flow-line-h.delay-3 { animation-delay:-6s }
        .flow-line-h.delay-4 { animation-delay:-3s }
        @keyframes wave { 0%{stroke-dashoffset:1000} 100%{stroke-dashoffset:0} }
        .wave-path { stroke-dasharray:1000; animation: wave 20s linear infinite; }
        .wave-path.delay-2 { animation-delay:-8s }
        @keyframes particle-float { 0%,100%{transform:translateY(0) scale(1);opacity:.3} 50%{transform:translateY(-30px) scale(1.2);opacity:.8} }
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
                <a href="/" class="group flex items-center gap-1.5 px-3 py-2 xl:px-4 xl:py-2.5 text-[15px] xl:text-base font-semibold text-emerald-600 rounded-lg hover:bg-emerald-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Home</span>
                </a>
                <a href="{{ route('features') }}" class="group flex items-center gap-1.5 px-3 py-2 xl:px-4 xl:py-2.5 text-[15px] xl:text-base font-semibold text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 14H11V3.055z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"/></svg>
                    <span>Features</span>
                </a>
                <a href="{{ route('how-it-works') }}" class="group flex items-center gap-1.5 px-3 py-2 xl:px-4 xl:py-2.5 text-[15px] xl:text-base font-semibold text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    <span>How It Works</span>
                </a>
                <a href="{{ route('about') }}" class="group flex items-center gap-1.5 px-3 py-2 xl:px-4 xl:py-2.5 text-[15px] xl:text-base font-semibold text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-50 transition-colors">
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
                <a href="/" class="flex items-center gap-3 px-4 py-2.5 text-sm font-medium text-emerald-600 bg-emerald-50 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
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
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-md hover:bg-emerald-100 transition-colors">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="flex-1 flex items-center justify-center gap-1.5 py-2.5 text-xs font-semibold text-white bg-emerald-600 rounded-md hover:bg-emerald-700 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</header>

{{-- ===================== HERO ===================== --}}
<section class="relative min-h-[92vh] flex items-center overflow-hidden pt-[88px] lg:pt-[96px] xl:pt-[116px] 2xl:pt-[126px]" id="hero">
    <div class="absolute inset-0">
        {{-- Base gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700"></div>

        {{-- Glow orbs --}}
        <div class="absolute top-0 right-0 w-[600px] h-[600px] rounded-full bg-gold-400/10 blur-[120px]"></div>
        <div class="absolute bottom-0 left-0 w-[500px] h-[500px] rounded-full bg-emerald-400/10 blur-[100px]"></div>
        <div class="absolute top-1/2 left-1/3 w-[400px] h-[400px] rounded-full bg-emerald-300/5 blur-[80px]"></div>

        {{-- Grid lines --}}
        <svg class="absolute inset-0 w-full h-full opacity-15" xmlns="http://www.w3.org/2000/svg">
            <defs><pattern id="grid" width="50" height="50" patternUnits="userSpaceOnUse"><path d="M 50 0 L 0 0 0 50" fill="none" stroke="rgba(255,255,255,0.06)" stroke-width="1"/></pattern></defs>
            <rect width="100%" height="100%" fill="url(#grid)"/>
        </svg>

        {{-- Dots pattern --}}
        <div class="absolute inset-0 opacity-30" style="background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px); background-size: 30px 30px;"></div>

        {{-- Animated lines --}}
        <svg class="absolute inset-0 w-full h-full pointer-events-none" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient id="lineGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%" style="stop-color:rgba(2,73,56,0);"/>
                    <stop offset="50%" style="stop-color:rgba(249,172,0,0.4);"/>
                    <stop offset="100%" style="stop-color:rgba(2,73,56,0);"/>
                </linearGradient>
            </defs>
            <line class="flow-line-h" x1="-10%" y1="20%" x2="110%" y2="20%" stroke="url(#lineGrad)" stroke-width="1"/>
            <line class="flow-line-h delay-1" x1="-10%" y1="35%" x2="110%" y2="35%" stroke="url(#lineGrad)" stroke-width="0.5"/>
            <line class="flow-line-h delay-2" x1="-10%" y1="50%" x2="110%" y2="50%" stroke="url(#lineGrad)" stroke-width="1"/>
            <line class="flow-line-h delay-3" x1="-10%" y1="65%" x2="110%" y2="65%" stroke="url(#lineGrad)" stroke-width="0.5"/>
            <line class="flow-line-h delay-4" x1="-10%" y1="80%" x2="110%" y2="80%" stroke="url(#lineGrad)" stroke-width="0.7"/>
            <path class="wave-path" d="M-100,300 Q200,200 500,300 T1100,300 T1700,300" fill="none" stroke="rgba(249,172,0,0.15)" stroke-width="1"/>
            <path class="wave-path delay-2" d="M-100,450 Q300,350 600,450 T1200,450" fill="none" stroke="rgba(2,73,56,0.12)" stroke-width="1"/>
        </svg>

        {{-- Floating particles --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="particle" style="top:10%;left:20%;width:4px;height:4px;background:rgba(249,172,0,0.5);border-radius:50%;animation:particle-float 8s ease-in-out infinite;"></div>
            <div class="particle" style="top:25%;left:70%;width:3px;height:3px;background:rgba(2,73,56,0.5);border-radius:50%;animation:particle-float 10s ease-in-out infinite 2s;"></div>
            <div class="particle" style="top:40%;left:40%;width:5px;height:5px;background:rgba(249,172,0,0.4);border-radius:50%;animation:particle-float 12s ease-in-out infinite 4s;"></div>
            <div class="particle" style="top:60%;left:80%;width:3px;height:3px;background:rgba(2,73,56,0.4);border-radius:50%;animation:particle-float 9s ease-in-out infinite 1s;"></div>
            <div class="particle" style="top:75%;left:15%;width:4px;height:4px;background:rgba(249,172,0,0.3);border-radius:50%;animation:particle-float 11s ease-in-out infinite 3s;"></div>
            <div class="particle" style="top:15%;left:55%;width:3px;height:3px;background:rgba(2,73,56,0.3);border-radius:50%;animation:particle-float 7s ease-in-out infinite 5s;"></div>
            <div class="particle" style="top:85%;left:60%;width:4px;height:4px;background:rgba(249,172,0,0.4);border-radius:50%;animation:particle-float 13s ease-in-out infinite 2s;"></div>
            <div class="particle" style="top:50%;left:90%;width:3px;height:3px;background:rgba(2,73,56,0.5);border-radius:50%;animation:particle-float 10s ease-in-out infinite 6s;"></div>
        </div>

        {{-- Bottom wave --}}
        <div class="absolute bottom-0 left-0 right-0">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" preserveAspectRatio="none" class="w-full"><path fill="white" d="M0,64L48,69.3C96,75,192,85,288,80C384,75,480,53,576,48C672,43,768,53,864,64C960,75,1056,85,1152,80C1248,75,1344,53,1392,42.7L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path></svg>
        </div>
    </div>

    {{-- Hero Content --}}
    <div class="relative z-10 max-w-7xl 2xl:max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12 py-20 lg:py-28 xl:py-36">
        <div class="max-w-4xl xl:max-w-5xl mx-auto text-center">
            <div class="text-center">
                {{-- Badge --}}
                <div class="animate-fade-up delay-1 inline-flex justify-between items-center py-1 pr-4 pl-1 xl:pr-5 xl:pl-1.5 mb-6 xl:mb-8 text-xs xl:text-sm text-emerald-100 bg-white/10 backdrop-blur-sm border border-emerald-400/30 rounded-full hover:bg-white/15 hover:border-emerald-400/50 transition-all">
                    <span class="text-[10px] xl:text-xs font-bold bg-emerald-500 rounded-full text-white px-3 py-1 mr-2 uppercase tracking-wide">New</span>
                    <span class="font-medium">Restora v1 is live</span>
                    <svg class="ml-1.5 w-3.5 h-3.5 xl:w-4 xl:h-4 text-emerald-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                </div>

                {{-- Heading --}}
                <h1 class="animate-fade-up delay-2 text-[2rem] sm:text-[2.4rem] md:text-5xl lg:text-[3.4rem] xl:text-[4.5rem] 2xl:text-[5.5rem] font-extrabold text-white leading-[1.1] mb-6 xl:mb-8">
                    Run Your Restaurant<br>
                    <span class="text-gold-300 inline-block">With Ease</span>
                </h1>

                {{-- Subheading --}}
                <p class="animate-fade-up delay-3 text-lg sm:text-xl md:text-2xl xl:text-3xl text-emerald-100/80 max-w-xl xl:max-w-2xl mx-auto mb-8 xl:mb-10 leading-relaxed">
                    Restora is the all-in-one restaurant management system. Take orders, serve customers, manage inventory, and grow your business — all from one place.
                </p>

                {{-- CTA Buttons --}}
                <div class="animate-fade-up delay-4 flex flex-row flex-wrap items-center gap-4 xl:gap-5 justify-center mb-10 xl:mb-12">
                    @auth
                        <a href="{{ url('/home') }}" class="group inline-flex items-center gap-2 xl:gap-3 px-7 py-3.5 xl:px-10 xl:py-5 text-base xl:text-lg font-bold text-gray-900 bg-gradient-to-r from-gold-300 to-gold-400 hover:from-gold-400 hover:to-gold-500 rounded-lg shadow-lg shadow-gold-500/30 hover:shadow-gold-500/40 transition-all duration-300 hover:-translate-y-0.5">
                            <span>Go to Dashboard</span>
                            <svg class="w-5 h-5 xl:w-6 xl:h-6 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="group inline-flex items-center gap-2 xl:gap-3 px-7 py-3.5 xl:px-10 xl:py-5 text-base xl:text-lg font-bold text-gray-900 bg-gradient-to-r from-gold-300 to-gold-400 hover:from-gold-400 hover:to-gold-500 rounded-lg shadow-lg shadow-gold-500/30 hover:shadow-gold-500/40 transition-all duration-300 hover:-translate-y-0.5">
                            <span>Get Started</span>
                            <svg class="w-5 h-5 xl:w-6 xl:h-6 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    @endauth
                    <a href="{{ route('how-it-works') }}" class="inline-flex items-center gap-2 xl:gap-3 px-7 py-3.5 xl:px-10 xl:py-5 text-base xl:text-lg font-semibold text-white border border-white/30 hover:border-white/60 rounded-lg backdrop-blur-sm transition-all hover:-translate-y-0.5">
                        <svg class="w-5 h-5 xl:w-6 xl:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>How It Works</span>
                    </a>
                </div>

                {{-- Trust indicators --}}
                <div class="animate-fade-up delay-5 flex flex-wrap items-center gap-5 xl:gap-7 justify-center text-emerald-200/80 text-sm xl:text-base">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-5 h-5 xl:w-6 xl:h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Secure & Reliable
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-5 h-5 xl:w-6 xl:h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Real-Time Orders
                    </div>
                    <div class="flex items-center gap-1.5">
                        <svg class="w-5 h-5 xl:w-6 xl:h-6 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        Inventory Management
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ===================== SCRIPTS ===================== --}}
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, easing: 'ease-in-out', once: true, offset: 100 });

document.querySelectorAll('a[href^="#"]').forEach(a=>{a.addEventListener('click',e=>{e.preventDefault();const t=document.querySelector(a.getAttribute('href'));if(t){window.scrollTo({top:t.getBoundingClientRect().top+window.pageYOffset-80,behavior:'smooth'})}})});

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
