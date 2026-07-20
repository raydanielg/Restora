@extends('layouts.frontend')

@section('title', 'How It Works')
@section('nav-how', 'text-emerald-600')

@section('content')
{{-- Hero Section --}}
<section class="relative py-20 lg:py-28 overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-gold-400/10 blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-emerald-400/10 blur-[100px]"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px); background-size: 30px 30px;"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <div class="animate-fade-up delay-1 inline-flex items-center gap-2 py-1.5 px-4 mb-6 text-xs text-emerald-100 bg-white/10 backdrop-blur-sm border border-emerald-400/30 rounded-full">
            <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            <span class="font-medium">Simple Process</span>
        </div>
        <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
            How Restora<br>
            <span class="text-gold-300">Works</span>
        </h1>
        <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto leading-relaxed">
            Get up and running in minutes. Follow these simple steps to transform your restaurant operations.
        </p>
    </div>
</section>

{{-- Steps Section --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-screen-xl 2xl:max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">

        {{-- Step 1 --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center mb-20 lg:mb-28">
            <div data-aos="fade-right">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-emerald-600 text-white text-2xl font-extrabold mb-6 shadow-lg shadow-emerald-600/30">1</div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Create Your Account</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Sign up for Restora in seconds. No credit card required. Just enter your restaurant details and you're ready to go.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Quick registration process</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Set up your restaurant profile</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Free to get started</span>
                    </li>
                </ul>
            </div>
            <div data-aos="fade-left" class="relative">
                <div class="aspect-[4/3] rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 flex items-center justify-center p-12">
                    <svg class="w-32 h-32 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                </div>
            </div>
        </div>

        {{-- Step 2 --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center mb-20 lg:mb-28">
            <div data-aos="fade-right" class="relative lg:order-1 order-2">
                <div class="aspect-[4/3] rounded-2xl bg-gradient-to-br from-gold-50 to-gold-100 border border-gold-200 flex items-center justify-center p-12">
                    <svg class="w-32 h-32 text-gold-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
            </div>
            <div data-aos="fade-left" class="lg:order-2 order-1">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gold-500 text-white text-2xl font-extrabold mb-6 shadow-lg shadow-gold-500/30">2</div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Set Up Your Menu</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Add your dishes, drinks, and specials with prices, categories, and images. Customize your menu in minutes.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-gold-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Add dishes with images and prices</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-gold-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Organize by categories</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-gold-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Toggle items on/off instantly</span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Step 3 --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center mb-20 lg:mb-28">
            <div data-aos="fade-right">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-blue-600 text-white text-2xl font-extrabold mb-6 shadow-lg shadow-blue-600/30">3</div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Start Taking Orders</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Take orders from your tables, send them to the kitchen instantly, and track everything in real-time.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Real-time order tracking</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Direct kitchen communication</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Table status management</span>
                    </li>
                </ul>
            </div>
            <div data-aos="fade-left" class="relative">
                <div class="aspect-[4/3] rounded-2xl bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 flex items-center justify-center p-12">
                    <svg class="w-32 h-32 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
            </div>
        </div>

        {{-- Step 4 --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div data-aos="fade-right" class="relative lg:order-1 order-2">
                <div class="aspect-[4/3] rounded-2xl bg-gradient-to-br from-purple-50 to-purple-100 border border-purple-200 flex items-center justify-center p-12">
                    <svg class="w-32 h-32 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
            </div>
            <div data-aos="fade-left" class="lg:order-2 order-1">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-purple-600 text-white text-2xl font-extrabold mb-6 shadow-lg shadow-purple-600/30">4</div>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Track & Grow</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Monitor your performance with real-time analytics. Track sales, identify trends, and make data-driven decisions.
                </p>
                <ul class="space-y-3">
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Real-time sales dashboards</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Inventory alerts and tracking</span>
                    </li>
                    <li class="flex items-center gap-3 text-gray-700">
                        <svg class="w-5 h-5 text-purple-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Detailed performance reports</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-20 lg:py-24 bg-gradient-to-br from-emerald-900 to-emerald-800 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-gold-400/10 blur-[100px]"></div>
    <div class="relative z-10 max-w-3xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Start your journey today</h2>
        <p class="text-lg text-emerald-100/80 mb-8">It only takes a few minutes to set up your restaurant on Restora.</p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            @auth
                <a href="{{ url('/home') }}" class="px-8 py-4 text-base font-bold text-gray-900 bg-gradient-to-r from-gold-300 to-gold-400 hover:from-gold-400 hover:to-gold-500 rounded-lg shadow-lg transition-all hover:-translate-y-0.5">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="px-8 py-4 text-base font-bold text-gray-900 bg-gradient-to-r from-gold-300 to-gold-400 hover:from-gold-400 hover:to-gold-500 rounded-lg shadow-lg transition-all hover:-translate-y-0.5">Get Started Free</a>
                <a href="{{ route('login') }}" class="px-8 py-4 text-base font-semibold text-white border border-white/30 hover:border-white/60 rounded-lg backdrop-blur-sm transition-all hover:-translate-y-0.5">Log in</a>
            @endauth
        </div>
    </div>
</section>
@endsection
