@extends('layouts.frontend')

@section('title', 'Features')
@section('nav-features', 'text-emerald-600')

@section('content')
{{-- Hero Section --}}
<section class="relative py-20 lg:py-28 overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-gold-400/10 blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-emerald-400/10 blur-[100px]"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px); background-size: 30px 30px;"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <div class="animate-fade-up delay-1 inline-flex items-center gap-2 py-1.5 px-4 mb-6 text-xs text-emerald-100 bg-white/10 backdrop-blur-sm border border-emerald-400/30 rounded-full">
            <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            <span class="font-medium">Powerful Features</span>
        </div>
        <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
            Everything You Need to<br>
            <span class="text-gold-300">Run Your Restaurant</span>
        </h1>
        <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto leading-relaxed">
            From order management to inventory tracking, Restora gives you all the tools to operate efficiently and grow your business.
        </p>
    </div>
</section>

{{-- Features Grid --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-screen-xl 2xl:max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">

            {{-- Feature 1: Order Management --}}
            <div data-aos="fade-up" class="group p-8 bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center mb-5 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Order Management</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Take and manage orders in real-time. Send orders directly to the kitchen, track status, and ensure fast service.</p>
            </div>

            {{-- Feature 2: Table Management --}}
            <div data-aos="fade-up" data-aos-delay="100" class="group p-8 bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-xl bg-gold-50 flex items-center justify-center mb-5 group-hover:bg-gold-100 transition-colors">
                    <svg class="w-7 h-7 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V6z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10h6M9 14h6"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Table Management</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Manage your dining area with visual table layouts. Track occupied, reserved, and available tables at a glance.</p>
            </div>

            {{-- Feature 3: Inventory Tracking --}}
            <div data-aos="fade-up" data-aos-delay="200" class="group p-8 bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center mb-5 group-hover:bg-blue-100 transition-colors">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Inventory Tracking</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Monitor stock levels in real-time. Get low-stock alerts, track ingredients, and reduce waste automatically.</p>
            </div>

            {{-- Feature 4: Staff Management --}}
            <div data-aos="fade-up" class="group p-8 bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-xl bg-purple-50 flex items-center justify-center mb-5 group-hover:bg-purple-100 transition-colors">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Staff Management</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Manage shifts, roles, and permissions. Track staff performance and assign tasks efficiently.</p>
            </div>

            {{-- Feature 5: Analytics & Reports --}}
            <div data-aos="fade-up" data-aos-delay="100" class="group p-8 bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center mb-5 group-hover:bg-emerald-100 transition-colors">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Analytics & Reports</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Get detailed insights into sales, popular dishes, peak hours, and revenue trends with real-time dashboards.</p>
            </div>

            {{-- Feature 6: Payment Integration --}}
            <div data-aos="fade-up" data-aos-delay="200" class="group p-8 bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-xl bg-gold-50 flex items-center justify-center mb-5 group-hover:bg-gold-100 transition-colors">
                    <svg class="w-7 h-7 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Payment Integration</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Accept mobile money, cards, and cash. Split bills, process refunds, and track all transactions in one place.</p>
            </div>

            {{-- Feature 7: Menu Management --}}
            <div data-aos="fade-up" class="group p-8 bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-xl bg-red-50 flex items-center justify-center mb-5 group-hover:bg-red-100 transition-colors">
                    <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Menu Management</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Create and update your menu with categories, prices, and images. Set specials and toggle item availability instantly.</p>
            </div>

            {{-- Feature 8: Kitchen Display --}}
            <div data-aos="fade-up" data-aos-delay="100" class="group p-8 bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center mb-5 group-hover:bg-blue-100 transition-colors">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Kitchen Display</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Digital kitchen tickets with real-time order routing. Track preparation time and eliminate paper tickets.</p>
            </div>

            {{-- Feature 9: Customer Loyalty --}}
            <div data-aos="fade-up" data-aos-delay="200" class="group p-8 bg-white rounded-2xl border border-gray-100 hover:border-emerald-200 hover:shadow-xl transition-all duration-300">
                <div class="w-14 h-14 rounded-xl bg-purple-50 flex items-center justify-center mb-5 group-hover:bg-purple-100 transition-colors">
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h3 class="text-xl font-bold text-gray-900 mb-3">Customer Loyalty</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Reward repeat customers with loyalty points, discounts, and special offers. Track customer preferences and history.</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-20 lg:py-24 bg-gradient-to-br from-emerald-900 to-emerald-800 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-gold-400/10 blur-[100px]"></div>
    <div class="relative z-10 max-w-3xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-extrabold text-white mb-4">Ready to transform your restaurant?</h2>
        <p class="text-lg text-emerald-100/80 mb-8">Join Restora today and take your business to the next level.</p>
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
