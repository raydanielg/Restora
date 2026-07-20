@extends('layouts.frontend')

@section('title', 'About')
@section('nav-about', 'text-emerald-600')

@section('content')
{{-- Hero Section --}}
<section class="relative py-20 lg:py-28 overflow-hidden bg-gradient-to-br from-emerald-900 via-emerald-800 to-emerald-700">
    <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full bg-gold-400/10 blur-[120px]"></div>
    <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full bg-emerald-400/10 blur-[100px]"></div>
    <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(rgba(255,255,255,0.12) 1px, transparent 1px); background-size: 30px 30px;"></div>

    <div class="relative z-10 max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <div class="animate-fade-up delay-1 inline-flex items-center gap-2 py-1.5 px-4 mb-6 text-xs text-emerald-100 bg-white/10 backdrop-blur-sm border border-emerald-400/30 rounded-full">
            <svg class="w-4 h-4 text-gold-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-medium">About Restora</span>
        </div>
        <h1 class="animate-fade-up delay-2 text-4xl md:text-5xl lg:text-6xl font-extrabold text-white leading-tight mb-6">
            Built for<br>
            <span class="text-gold-300">Restaurants</span>
        </h1>
        <p class="animate-fade-up delay-3 text-lg md:text-xl text-emerald-100/80 max-w-2xl mx-auto leading-relaxed">
            Restora was created to simplify restaurant management — from small cafes to busy dining establishments.
        </p>
    </div>
</section>

{{-- Story Section --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-screen-xl 2xl:max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div data-aos="fade-right">
                <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-6">Our Story</h2>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    Restora was born from a simple observation: restaurant owners juggle too many tools, spreadsheets, and paper tickets. We believed there had to be a better way.
                </p>
                <p class="text-gray-600 text-lg leading-relaxed mb-6">
                    So we built Restora — an all-in-one platform that handles everything from order taking to inventory management, staff scheduling, and business analytics. No more switching between apps or losing track of orders.
                </p>
                <p class="text-gray-600 text-lg leading-relaxed">
                    Today, Restora helps restaurants of all sizes operate more efficiently, serve customers faster, and grow their business with confidence.
                </p>
            </div>
            <div data-aos="fade-left" class="relative">
                <div class="aspect-[4/3] rounded-2xl bg-gradient-to-br from-emerald-50 to-emerald-100 border border-emerald-200 flex items-center justify-center p-12">
                    <img src="{{ asset('logo.png') }}?v=2" alt="Restora" class="w-48 h-48 object-contain">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Mission & Vision --}}
<section class="py-20 lg:py-28 bg-gray-50">
    <div class="max-w-screen-xl 2xl:max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
            {{-- Mission --}}
            <div data-aos="fade-up" class="p-8 lg:p-10 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-14 h-14 rounded-xl bg-emerald-50 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Mission</h3>
                <p class="text-gray-600 text-base leading-relaxed">
                    To empower restaurants with simple, powerful technology that streamlines operations, enhances customer experience, and drives growth. We believe every restaurant deserves tools that work as hard as they do.
                </p>
            </div>

            {{-- Vision --}}
            <div data-aos="fade-up" data-aos-delay="100" class="p-8 lg:p-10 bg-white rounded-2xl border border-gray-100 shadow-sm">
                <div class="w-14 h-14 rounded-xl bg-gold-50 flex items-center justify-center mb-5">
                    <svg class="w-7 h-7 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-4">Our Vision</h3>
                <p class="text-gray-600 text-base leading-relaxed">
                    To become the leading restaurant management platform — where every restaurant, no matter its size, has access to enterprise-grade tools that help them compete, thrive, and grow in a digital world.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Values Section --}}
<section class="py-20 lg:py-28 bg-white">
    <div class="max-w-screen-xl 2xl:max-w-screen-2xl mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
        <div class="text-center mb-12 lg:mb-16">
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Our Core Values</h2>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">The principles that guide everything we build.</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
            <div data-aos="fade-up" class="text-center p-6">
                <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2">Simplicity</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Powerful tools that are easy to use. No training required.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100" class="text-center p-6">
                <div class="w-16 h-16 rounded-2xl bg-gold-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gold-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2">Reliability</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Built to perform when it matters most — during rush hour.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200" class="text-center p-6">
                <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2">Innovation</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Always evolving with the latest technology and trends.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="300" class="text-center p-6">
                <div class="w-16 h-16 rounded-2xl bg-purple-50 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <h4 class="text-lg font-bold text-gray-900 mb-2">Customer First</h4>
                <p class="text-gray-600 text-sm leading-relaxed">Every feature is built with our customers' needs in mind.</p>
            </div>
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section class="py-20 lg:py-24 bg-gradient-to-br from-emerald-900 to-emerald-800 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-[400px] h-[400px] rounded-full bg-gold-400/10 blur-[100px]"></div>
    <div class="relative z-10 max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 text-center">
            <div data-aos="fade-up">
                <div class="text-4xl lg:text-5xl font-extrabold text-gold-300 mb-2">100+</div>
                <p class="text-emerald-100/70 text-sm">Restaurants Served</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100">
                <div class="text-4xl lg:text-5xl font-extrabold text-gold-300 mb-2">50K+</div>
                <p class="text-emerald-100/70 text-sm">Orders Processed</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="200">
                <div class="text-4xl lg:text-5xl font-extrabold text-gold-300 mb-2">99.9%</div>
                <p class="text-emerald-100/70 text-sm">Uptime Guaranteed</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="300">
                <div class="text-4xl lg:text-5xl font-extrabold text-gold-300 mb-2">24/7</div>
                <p class="text-emerald-100/70 text-sm">Support Available</p>
            </div>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-20 lg:py-24 bg-white">
    <div class="max-w-3xl mx-auto text-center px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-extrabold text-gray-900 mb-4">Join the Restora family</h2>
        <p class="text-lg text-gray-600 mb-8">Be part of a growing community of restaurants that trust Restora to power their operations.</p>
        <div class="flex flex-wrap items-center justify-center gap-4">
            @auth
                <a href="{{ url('/home') }}" class="px-8 py-4 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-lg transition-all hover:-translate-y-0.5">Go to Dashboard</a>
            @else
                <a href="{{ route('register') }}" class="px-8 py-4 text-base font-bold text-white bg-emerald-600 hover:bg-emerald-700 rounded-lg shadow-lg transition-all hover:-translate-y-0.5">Get Started Free</a>
                <a href="{{ route('login') }}" class="px-8 py-4 text-base font-semibold text-emerald-700 border border-emerald-200 hover:border-emerald-400 rounded-lg transition-all hover:-translate-y-0.5">Log in</a>
            @endauth
        </div>
    </div>
</section>
@endsection
