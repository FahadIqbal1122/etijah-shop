@extends('layouts.admin')
@section('title', 'Orders')

@section('content')

<div class="flex items-center gap-2 mb-6">
    @foreach (['' => 'All', 'pending' => 'Pending', 'paid' => 'Paid', 'failed' => 'Failed'] as $value => $label)
        <a href="{{ route('admin.orders', $value ? ['status' => $value] : []) }}"
           @class([
                'px-3.5 py-1.5 rounded-full text-sm font-medium border transition-colors',
                'bg-brand-700 text-white border-brand-700' => $status === $value || (!$status && $value === ''),
                'bg-white text-slate-600 border-slate-200 hover:border-brand-200' => !($status === $value || (!$status && $value === '')),
           ])>{{ $label }}</a>
    @endforeach
</div>

<div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
            <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                <th class="px-5 py-3">Customer</th>
                <th class="px-5 py-3">Product</th>
                <th class="px-5 py-3">Amount</th>
                <th class="px-5 py-3">Payment</th>
                <th class="px-5 py-3">Status</th>
                <th class="px-5 py-3">Source</th>
                <th class="px-5 py-3">Date</th>
                <th class="px-5 py-3"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($orders as $order)
                <tr>
                    <td class="px-5 py-3.5">
                        <div class="font-medium text-slate-900">{{ $order->first_name }} {{ $order->last_name }}</div>
                        <div class="text-slate-500 text-xs">{{ $order->email }}</div>
                        @if ($order->phone)
                            <div class="text-slate-400 text-xs">{{ $order->phone }}</div>
                        @endif
                    </td>
                    <td class="px-5 py-3.5 text-slate-700">{{ $order->product_name }}</td>
                    <td class="px-5 py-3.5 text-slate-700">{{ number_format($order->amount, 3) }} {{ $order->currency }}</td>
                    <td class="px-5 py-3.5 text-slate-500 uppercase text-xs">{{ $order->payment_method }}</td>
                    <td class="px-5 py-3.5">
                        <span @class([
                            'inline-flex px-2.5 py-1 rounded-full text-xs font-medium',
                            'bg-emerald-50 text-emerald-700' => $order->status === 'paid',
                            'bg-amber-50 text-amber-700' => $order->status === 'pending',
                            'bg-red-50 text-red-700' => $order->status === 'failed',
                        ])>{{ ucfirst($order->status) }}</span>
                    </td>
                    <td class="px-5 py-3.5 text-slate-500 text-xs">{{ $order->source ?? 'shop' }}</td>
                    <td class="px-5 py-3.5 text-slate-500">{{ $order->created_at->format('M j, Y g:ia') }}</td>
                    <td class="px-5 py-3.5 text-right whitespace-nowrap">
                        <a href="{{ route('admin.orders.invoice', $order) }}" target="_blank" class="text-brand-700 hover:text-brand-800 text-sm font-medium mr-4">Invoice</a>
                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    data-confirm
                                    data-confirm-label="Click again to confirm"
                                    class="text-red-600 hover:text-red-800 text-sm font-medium border border-transparent rounded px-2 py-1 -mx-2 -my-1">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-5 py-8 text-center text-slate-400">No orders found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>

@endsection
