<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} — Etijah Coaching</title>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        @media print {
            .no-print { display: none !important; }
            body { background: white !important; }
        }
    </style>
</head>
<body class="bg-slate-100 text-slate-900 antialiased">

    <div class="no-print max-w-3xl mx-auto pt-6 px-6 flex justify-end">
        <button onclick="window.print()" class="bg-brand-700 hover:bg-brand-800 text-white text-sm font-semibold px-5 py-2.5 rounded-lg transition-colors duration-200">
            Print / Save as PDF
        </button>
    </div>

    <div class="max-w-3xl mx-auto my-6 bg-white rounded-2xl shadow-sm border border-slate-200 p-10 print:shadow-none print:border-0 print:rounded-none">

        <div class="flex items-start justify-between mb-10">
            <div>
                <img src="{{ asset('images/logo.png') }}" alt="Etijah Logo" class="h-9 mb-3">
                <p class="text-slate-500 text-sm">Etijah Coaching & Consulting</p>
            </div>
            <div class="text-right">
                <h1 class="text-2xl font-bold text-slate-900">Invoice</h1>
                <p class="text-slate-500 text-sm mt-1">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</p>
                <p class="text-slate-500 text-sm">{{ $order->created_at->format('M j, Y') }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-10">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Billed To</p>
                <p class="font-medium text-slate-900">{{ $order->first_name }} {{ $order->last_name }}</p>
                <p class="text-slate-500 text-sm">{{ $order->email }}</p>
                @if ($order->phone)
                    <p class="text-slate-500 text-sm">{{ $order->phone }}</p>
                @endif
            </div>
            <div class="text-right">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Payment Status</p>
                <span @class([
                    'inline-flex px-2.5 py-1 rounded-full text-xs font-medium',
                    'bg-emerald-50 text-emerald-700' => $order->status === 'paid',
                    'bg-amber-50 text-amber-700' => $order->status === 'pending',
                    'bg-red-50 text-red-700' => $order->status === 'failed',
                ])>{{ ucfirst($order->status) }}</span>
                <p class="text-slate-500 text-sm mt-2 uppercase">{{ $order->payment_method }}</p>
                @if ($order->paid_at)
                    <p class="text-slate-400 text-xs mt-1">Paid {{ $order->paid_at->format('M j, Y g:ia') }}</p>
                @endif
            </div>
        </div>

        <table class="w-full text-sm mb-8">
            <thead>
                <tr class="border-b border-slate-200 text-left text-xs font-semibold text-slate-400 uppercase tracking-wide">
                    <th class="pb-3">Description</th>
                    <th class="pb-3 text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr class="border-b border-slate-100">
                    <td class="py-4 text-slate-700">{{ $order->product_name }}</td>
                    <td class="py-4 text-right text-slate-700">{{ number_format($order->amount, 3) }} {{ $order->currency }}</td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td class="pt-4 text-right font-semibold text-slate-900">Total</td>
                    <td class="pt-4 text-right font-bold text-lg text-slate-900">{{ number_format($order->amount, 3) }} {{ $order->currency }}</td>
                </tr>
            </tfoot>
        </table>

        @if ($order->notes)
            <div class="mb-8">
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide mb-2">Notes</p>
                <p class="text-slate-600 text-sm">{{ $order->notes }}</p>
            </div>
        @endif

        <div class="border-t border-slate-100 pt-6 text-center text-slate-400 text-xs">
            Thank you for choosing Etijah Coaching & Consulting.
        </div>
    </div>

</body>
</html>
