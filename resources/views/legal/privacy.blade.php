@extends('layouts.app')
@section('title', 'Privacy Policy — Etijah Coaching')

@section('content')

<section class="bg-white border-b border-slate-200">
    <div class="max-w-3xl mx-auto px-6 py-14">
        <span class="inline-block text-xs font-semibold tracking-widest text-brand-700 uppercase mb-3 bg-brand-50 px-3 py-1 rounded-full border border-brand-100">Legal</span>
        <h1 class="font-display text-4xl font-bold text-slate-900 mb-3">Privacy Policy</h1>
        <p class="text-slate-400 text-sm">Last updated: {{ date('F Y') }}</p>
    </div>
</section>

<section class="max-w-3xl mx-auto px-6 py-12">
    <div class="bg-white rounded-2xl border border-slate-200 p-8 md:p-12 prose prose-slate max-w-none">
        <p class="text-slate-500 leading-relaxed">
            Our privacy policy will be updated soon. Please check back later.
        </p>
    </div>
</section>

@endsection
