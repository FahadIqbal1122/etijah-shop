@extends('layouts.admin')
@section('title', 'Order #' . $order->id)

@section('content')

@php
    $rows = [
        'Order ID' => '#' . $order->id,
        'Customer' => $order->first_name . ' ' . $order->last_name,
        'Email' => $order->email,
        'Phone' => $order->phone ?: '—',
        'Product' => $order->product_name . ' (' . $order->product_key . ')',
        'Amount' => number_format($order->amount, 3) . ' ' . $order->currency,
        'Payment method' => strtoupper($order->payment_method ?? '—'),
        'Source' => $order->source ?? 'shop',
        'Created' => $order->created_at->format('M j, Y g:i:s a') . ' (' . $order->created_at->timezoneName . ')',
        'Paid at' => $order->paid_at ? $order->paid_at->format('M j, Y g:i:s a') : '—',
        'Customer notes' => $order->notes ?: '—',
    ];
    $tech = [
        'Tap charge ID' => $order->tap_charge_id ?: '—',
        'External ref (order_ref)' => $order->external_ref ?: '—',
        'External user ID' => $order->external_user_id ?: '—',
        'Return URL' => $order->return_url ?: '—',
    ];
@endphp

<div class="flex items-center justify-between mb-6">
    <a href="{{ route('admin.orders') }}" class="text-brand-700 hover:text-brand-800 text-sm font-medium">&larr; Back to orders</a>
    <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="text-brand-700 hover:text-brand-800 text-sm font-medium">Invoice</a>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">
    <div class="px-5 py-3 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
        <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Order</span>
        <span @class([
            'inline-flex px-2.5 py-1 rounded-full text-xs font-medium',
            'bg-emerald-50 text-emerald-700' => $order->status === 'paid',
            'bg-amber-50 text-amber-700' => $order->status === 'pending',
            'bg-red-50 text-red-700' => $order->status === 'failed',
        ])>{{ ucfirst($order->status) }}</span>
    </div>
    <table class="w-full text-sm">
        <tbody class="divide-y divide-slate-100">
            @foreach ($rows as $label => $value)
                <tr>
                    <td class="px-5 py-3 text-slate-500 w-56">{{ $label }}</td>
                    <td class="px-5 py-3 text-slate-900">{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@if ($order->failure_reason)
    <div class="bg-white rounded-xl border border-red-200 overflow-hidden mb-6">
        <div class="px-5 py-3 bg-red-50 border-b border-red-200 text-xs font-semibold text-red-700 uppercase tracking-wide">Failure reason</div>
        <div class="px-5 py-4 text-sm text-slate-800 break-all">{{ $order->failure_reason }}</div>
    </div>
@endif

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">
    <div class="px-5 py-3 bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wide">References</div>
    <table class="w-full text-sm">
        <tbody class="divide-y divide-slate-100">
            @foreach ($tech as $label => $value)
                <tr>
                    <td class="px-5 py-3 text-slate-500 w-56">{{ $label }}</td>
                    <td class="px-5 py-3 text-slate-900 break-all">{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden mb-6">
    <div class="px-5 py-3 bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-500 uppercase tracking-wide">Tap (live lookup)</div>
    @if ($charge)
        <table class="w-full text-sm">
            <tbody class="divide-y divide-slate-100">
                @foreach ([
                    'Tap status' => $charge['status'] ?? '—',
                    'Amount / currency' => ($charge['amount'] ?? '—') . ' ' . ($charge['currency'] ?? ''),
                    'Response code' => $charge['response']['code'] ?? '—',
                    'Response message' => $charge['response']['message'] ?? '—',
                    'Gateway response' => ($charge['gateway']['response']['code'] ?? '—') . ' ' . ($charge['gateway']['response']['message'] ?? ''),
                    'Payment method' => $charge['source']['payment_method'] ?? ($charge['source']['type'] ?? '—'),
                    'Card' => isset($charge['card']['last_four']) ? ($charge['card']['brand'] ?? '') . ' •••• ' . $charge['card']['last_four'] : '—',
                    'Created (ms epoch)' => $charge['transaction']['created'] ?? '—',
                ] as $label => $value)
                    <tr>
                        <td class="px-5 py-3 text-slate-500 w-56">{{ $label }}</td>
                        <td class="px-5 py-3 text-slate-900 break-all">{{ $value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @elseif ($chargeError)
        <div class="px-5 py-4 text-sm text-red-700 break-all">Could not fetch from Tap: {{ $chargeError }}</div>
    @else
        <div class="px-5 py-4 text-sm text-slate-500">No Tap charge was created for this order, so the customer never reached the payment page.</div>
    @endif
</div>

@endsection
