@extends('layouts.app')
@section('title', 'Etijah Coaching — Your Growth Hub')

@section('content')

{{-- Hero --}}
<section class="relative bg-white overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_#dbeafe_0%,_transparent_60%)]"></div>
    <div class="relative max-w-6xl mx-auto px-6 py-24 md:py-32">
        <div class="max-w-2xl">
            <span class="inline-block text-xs font-semibold tracking-widest text-brand-700 uppercase mb-4 bg-brand-50 px-3 py-1 rounded-full border border-brand-100">
                Etijah Coaching & Consulting
            </span>
            <h1 class="font-display text-5xl md:text-6xl font-bold text-slate-900 leading-tight mb-6">
                Your hub for<br>
                <span class="text-brand-700">growth &amp; transformation.</span>
            </h1>
            <p class="text-lg text-slate-500 leading-relaxed mb-10 font-light">
                Everything you need to unlock your potential — expert coaching, career tools, and resources — all in one place.
            </p>
            <div class="flex items-center gap-4">
                <a href="/shop" class="bg-brand-700 hover:bg-brand-800 text-white font-semibold px-7 py-3.5 rounded-full transition-all duration-200 shadow-lg shadow-brand-200 hover:shadow-xl hover:shadow-brand-200">
                    Browse Products
                </a>
                <a href="#offerings" class="text-slate-600 hover:text-brand-700 font-medium text-sm transition-colors duration-200 flex items-center gap-1.5">
                    See what we offer
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Divider --}}
<div class="border-t border-slate-100"></div>

{{-- Offerings --}}
<section id="offerings" class="max-w-6xl mx-auto px-6 py-20">
    <div class="text-center mb-14">
        <h2 class="font-display text-3xl md:text-4xl font-bold text-slate-900 mb-4">What We Offer</h2>
        <p class="text-slate-500 text-base max-w-lg mx-auto">A growing suite of products designed to support your personal and professional journey.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Coaching Sessions Card --}}
        <a href="/shop" class="group bg-white rounded-2xl border border-slate-200 p-7 hover:border-brand-200 hover:shadow-xl hover:shadow-brand-50 transition-all duration-300 flex flex-col">
            <div class="w-11 h-11 bg-brand-50 rounded-xl flex items-center justify-center mb-5 group-hover:bg-brand-100 transition-colors duration-200">
                <svg class="w-5 h-5 text-brand-700" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4a4 4 0 11-8 0 4 4 0 018 0zm6 4a4 4 0 00-3-3.87"/>
                </svg>
            </div>
            <h3 class="text-base font-semibold text-slate-900 mb-2">Coaching Sessions</h3>
            <p class="text-slate-500 text-sm leading-relaxed flex-1">1-on-1 sessions with an expert coach tailored to your personal and professional goals.</p>
            <span class="mt-5 text-brand-700 text-sm font-medium flex items-center gap-1 group-hover:gap-2 transition-all duration-200">
                View sessions
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </span>
        </a>

    </div>
</section>

{{-- Visit Main Site Banner --}}
<section class="bg-brand-700">
    <div class="max-w-6xl mx-auto px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
        <p class="text-brand-100 text-sm text-center sm:text-left">
            Looking for all of Etijah's services? Visit our main website.
        </p>
        <a href="https://etijahcoaching.com" target="_blank" rel="noopener noreferrer"
           class="shrink-0 bg-white hover:bg-brand-50 text-brand-700 text-sm font-semibold px-5 py-2 rounded-full transition-all duration-200">
            Visit etijahcoaching.com →
        </a>
    </div>
</section>

{{-- Trust Bar --}}
<section class="bg-white border-t border-slate-100">
    <div class="max-w-6xl mx-auto px-6 py-12 text-center">
        <p class="text-slate-400 text-xs uppercase tracking-widest font-medium mb-6">Trusted by professionals across the region</p>
        <div class="flex flex-wrap justify-center gap-10 text-slate-300 text-sm font-light">
            <span class="text-slate-500 font-medium">Secure Payments via Tap</span>
            <span>·</span>
            <span class="text-slate-500 font-medium">Expert-led Sessions</span>
            <span>·</span>
            <span class="text-slate-500 font-medium">Bahrain Based</span>
        </div>
    </div>
</section>

@endsection
