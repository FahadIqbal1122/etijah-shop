@extends('layouts.admin')
@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-slate-500 text-xs font-medium uppercase tracking-wide mb-1.5">Total Orders</p>
        <p class="text-2xl font-bold text-slate-900">{{ $stats['total_orders'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-slate-500 text-xs font-medium uppercase tracking-wide mb-1.5">Paid Orders</p>
        <p class="text-2xl font-bold text-emerald-600">{{ $stats['paid_orders'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-slate-500 text-xs font-medium uppercase tracking-wide mb-1.5">Pending Orders</p>
        <p class="text-2xl font-bold text-amber-600">{{ $stats['pending_orders'] }}</p>
    </div>
    <div class="bg-white rounded-xl border border-slate-200 p-5">
        <p class="text-slate-500 text-xs font-medium uppercase tracking-wide mb-1.5">Revenue (Paid)</p>
        <p class="text-2xl font-bold text-slate-900">{{ number_format($stats['revenue'], 3) }}</p>
    </div>
</div>

<div class="flex items-center justify-between mb-4">
    <h2 class="font-semibold text-lg text-slate-900">Recent Orders</h2>
    <a href="{{ route('admin.orders') }}" class="text-sm font-medium text-brand-700 hover:text-brand-800">View all →</a>
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                <th class="px-5 py-3">Customer</th>
                <th class="px-5 py-3">Product</th>
                <th class="px-5 py-3">Amount</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3">Date</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($recentOrders as $order)
                <tr>
                    <td class="px-5 py-3.5">
                        <div class="font-medium text-slate-900">{{ $order->first_name }} {{ $order->last_name }}</div>
                        <div class="text-slate-500 text-xs">{{ $order->email }}</div>
                    </td>
                    <td class="px-5 py-3.5 text-slate-700">{{ $order->product_name }}</td>
                    <td class="px-5 py-3.5 text-slate-700">{{ number_format($order->amount, 3) }} {{ $order->currency }}</td>
                    <td class="px-5 py-3.5">
                        <span @class([
                            'inline-flex px-2.5 py-1 rounded-full text-xs font-medium',
                            'bg-emerald-50 text-emerald-700' => $order->status === 'paid',
                            'bg-amber-50 text-amber-700' => $order->status === 'pending',
                            'bg-red-50 text-red-700' => $order->status === 'failed',
                        ])>{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-500">{{ $order->created_at->format('M j, Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-5 py-8 text-center text-slate-400">No orders yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
