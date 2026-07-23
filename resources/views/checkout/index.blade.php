@extends('layouts.app')
@section('title', 'Checkout — Etijah Coaching')

@section('content')
<section class="max-w-5xl mx-auto px-6 py-14">

    <div class="mb-8">
        <span class="text-xs font-semibold tracking-widest text-brand-700 uppercase bg-brand-50 px-3 py-1 rounded-full border border-brand-100">
            Secure Checkout
        </span>
        <h1 class="font-display text-3xl font-bold text-slate-900 mt-4">Complete Your Order</h1>
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-5 py-4 text-sm text-red-700 space-y-1">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
  
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">

        {{-- Left: Form --}}
        <div class="lg:col-span-3">
            <div class="bg-white rounded-2xl border border-slate-200 p-8">
                <h2 class="text-base font-semibold text-slate-800 mb-6">Your Details</h2>

                <form action="/checkout" method="POST" id="checkout-form">
                    @csrf
                    <input type="hidden" name="product_key" value="{{ $productKey }}">
  
                    <div class="space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">First Name</label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500         
  focus:border-transparent transition"                                                                                                                                                                                                           placeholder="Ahmed">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1.5">Last Name</label>
                                <input type="text" name="last_name" value="{{ old('last_name') }}" required
                                    class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500
  focus:border-transparent transition"
                                    placeholder="Al-Mansoori">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Email Address</label>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500
  focus:border-transparent transition"
                                  placeholder="ahmed@example.com">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Phone Number</label>
                            <input type="tel" name="phone" value="{{ old('phone') }}"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500
  focus:border-transparent transition" placeholder="+973 3XXX XXXX">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1.5">Notes (optional)</label>
                            <textarea name="notes" rows="3"
                                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-brand-500
  focus:border-transparent transition resize-none"
                                  placeholder="Any additional information...">{{ old('notes') }}</textarea>
                        </div>

                        {{-- Payment Method --}}
                        <div class="pt-2 border-t border-slate-100">
                            <h2 class="text-base font-semibold text-slate-800 mb-4">Payment Method</h2>

                            <label class="flex items-start gap-4 border border-brand-500 bg-brand-50 rounded-xl p-4 cursor-pointer">
                                <input type="radio" name="payment_method" value="cod" checked class="mt-0.5 accent-brand-700">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Cash on Delivery</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Pay in cash when we contact you to confirm your booking.</p>
                                </div>
                            </label>

                            <label class="flex items-start gap-4 border border-slate-200 rounded-xl p-4 cursor-pointer mt-3">
                                <input type="radio" name="payment_method" value="tap" class="mt-0.5 accent-brand-700">
                                <div>
                                    <p class="text-sm font-semibold text-slate-800">Pay by Card</p>
                                    <p class="text-xs text-slate-500 mt-0.5">Secure payment via Tap — Visa, Mastercard, mada, and more.</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    <button type="submit"
                        class="mt-8 w-full bg-brand-700 hover:bg-brand-800 text-white font-semibold py-4 rounded-xl transition-all duration-200 shadow-sm hover:shadow-md text-sm">
                        Place Order — {{ $product['price'] }} {{ $product['currency'] }}
                    </button>
                </form>
            </div>
        </div>

        {{-- Right: Order Summary --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-slate-200 p-7 sticky top-24">
                <h2 class="text-base font-semibold text-slate-800 mb-5">Order Summary</h2>

                <div class="flex items-start gap-4 pb-5 border-b border-slate-100">
                    <div class="w-11 h-11 bg-brand-700 rounded-xl flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-5-3.87M9 20H4v-2a4 4 0 015-3.87m6-4a4 4 0 11-8 0 4 4 0 018 0zm6 4a4 4 0 00-3-3.87"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-semibold text-slate-900">{{ $product['name'] }}</p>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $product['description'] }}</p>
                    </div>
                </div>

                <div class="mt-5 space-y-3">
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>Subtotal</span>
                        <span>{{ $product['price'] }} {{ $product['currency'] }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-slate-600">
                        <span>VAT (0%)</span>
                        <span>0.000 BHD</span>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-t border-slate-100 flex justify-between">
                    <span class="font-semibold text-slate-900">Total</span>
                    <div class="text-right">
                        <span class="font-bold text-xl text-slate-900">{{ $product['price'] }}</span>
                        <span class="text-slate-500 text-sm ml-1">{{ $product['currency'] }}</span>
                    </div>
                </div>

                <div class="mt-6 pt-5 border-t border-slate-100 space-y-2">
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 
  10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>                                                                                                                                                       </svg>
                        Secure order processing
                    </div>
                    <div class="flex items-center gap-2 text-xs text-slate-400">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>                                                                                                                              </svg>
                        We'll confirm your booking via email
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection