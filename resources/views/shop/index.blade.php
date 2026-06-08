@extends('layouts.app')
@section('title', 'Shop — Etijah Coaching')

@section('content')

{{-- Page Header --}}
<section class="bg-white border-b border-slate-200">
    <div class="max-w-6xl mx-auto px-6 py-14">
        <span class="inline-block text-xs font-semibold tracking-widest text-brand-700 uppercase mb-3 bg-brand-50 px-3 py-1 rounded-full border border-brand-100">
            All Products
        </span>
        <h1 class="font-display text-4xl font-bold text-slate-900 mb-3">Etijah Shop</h1>
        <p class="text-slate-500 text-base max-w-lg">Browse our products and invest in your growth today.</p>
    </div>
</section>

{{-- Products Grid --}}
<section class="max-w-6xl mx-auto px-6 py-12">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Coaching Session Card --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden hover:border-brand-200 hover:shadow-xl hover:shadow-brand-50 transition-all duration-300 flex flex-col">
            <div class="bg-gradient-to-br from-brand-600 to-brand-800 px-7 pt-8 pb-6">
                <div class="w-11 h-11 bg-white/20 rounded-xl flex items-center justify-center mb-4">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4a4 4 0 11-8 0 4 4 0 018 0zm6 4a4 4 0 00-3-3.87"/>
                    </svg>
                </div>
                <h2 class="text-white font-display text-xl font-semibold">Coaching Session</h2>
                <p class="text-brand-100 text-sm mt-1">1-on-1 with an expert</p>
            </div>
            <div class="p-7 flex flex-col flex-1">
                <p class="text-slate-500 text-sm leading-relaxed flex-1">
                    A personalized coaching session with an experienced coach, tailored entirely to your goals and challenges.
                </p>
                <ul class="mt-4 space-y-2">
                    <li class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Personalized to your goals
                    </li>
                    <li class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Expert-led session
                    </li>
                    <li class="flex items-center gap-2 text-sm text-slate-600">
                        <svg class="w-4 h-4 text-brand-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        Flexible scheduling
                    </li>
                </ul>
                <div class="mt-6 pt-5 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <span class="text-2xl font-bold text-slate-900">60</span>
                        <span class="text-slate-500 text-sm font-medium ml-1">BHD</span>
                    </div>
                    <a href="/checkout?product=coaching" class="bg-brand-700 hover:bg-brand-800 text-white text-sm font-semibold px-5 py-2.5 rounded-full transition-all duration-200 shadow-sm hover:shadow-md">
                        Book Now
                    </a>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
