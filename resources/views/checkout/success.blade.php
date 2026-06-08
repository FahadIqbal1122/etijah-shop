@extends('layouts.app')
@section('title', 'Payment Successful — Etijah Coaching')

@section('content')
<section class="max-w-lg mx-auto px-6 py-24 text-center">
    <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
        </svg>
    </div>
    <h1 class="font-display text-3xl font-bold text-slate-900 mb-3">Payment Successful</h1>
    <p class="text-slate-500 text-base leading-relaxed mb-8">
        Thank you for your purchase. A confirmation has been sent to your email. We'll be in touch shortly.                                                                                              
    </p>                                                                                                                                                                                                 
    <a href="/shop" class="inline-block bg-brand-700 hover:bg-brand-800 text-white font-semibold px-8 py-3 rounded-full transition-all duration-200 shadow-sm text-sm">
        Back to Shop
    </a>                                                                                                                                                                                                   </section>
@endsection