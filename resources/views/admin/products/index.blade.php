@extends('layouts.admin')
@section('title', 'Products')

@section('content')

<div class="grid lg:grid-cols-3 gap-8">

    {{-- Product list --}}
    <div class="lg:col-span-2 bg-white rounded-xl border border-slate-200 overflow-hidden h-fit">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-200">
                <tr class="text-left text-xs font-semibold text-slate-500 uppercase tracking-wide">
                    <th class="px-5 py-3">Product</th>
                    <th class="px-5 py-3">Price</th>
                    <th class="px-5 py-3">Status</th>
                    <th class="px-5 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($products as $product)
                    <tr>
                        <td class="px-5 py-3.5">
                            <div class="font-medium text-slate-900">{{ $product->name }}</div>
                            <div class="text-slate-400 text-xs">key: {{ $product->key }}</div>
                        </td>
                        <td class="px-5 py-3.5 text-slate-700">{{ number_format($product->price, 3) }} {{ $product->currency }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-2.5">
                                <span @class([
                                    'inline-flex px-2.5 py-1 rounded-full text-xs font-medium',
                                    'bg-emerald-50 text-emerald-700' => $product->active,
                                    'bg-slate-100 text-slate-500' => !$product->active,
                                ])>{{ $product->active ? 'Active' : 'Unavailable' }}</span>
                                <form method="POST" action="{{ route('admin.products.update', $product) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="name" value="{{ $product->name }}">
                                    <input type="hidden" name="description" value="{{ $product->description }}">
                                    <input type="hidden" name="price" value="{{ $product->price }}">
                                    <input type="hidden" name="currency" value="{{ $product->currency }}">
                                    <input type="hidden" name="sort_order" value="{{ $product->sort_order }}">
                                    <input type="hidden" name="active" value="{{ $product->active ? '0' : '1' }}">
                                    <button type="submit" class="text-xs font-medium text-slate-500 hover:text-slate-700 underline underline-offset-2">
                                        {{ $product->active ? 'Make unavailable' : 'Make available' }}
                                    </button>
                                </form>
                            </div>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        data-confirm
                                        data-confirm-label="Click again to confirm"
                                        class="text-red-600 hover:text-red-800 text-sm font-medium border border-transparent rounded px-2 py-1 -mx-2 -my-1">
                                    Remove
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-slate-400">No products yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Add product --}}
    <div class="bg-white rounded-xl border border-slate-200 p-6 h-fit">
        <h2 class="font-semibold text-slate-900 mb-5">Add Product</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3 rounded-lg">
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1.5">Key (unique, used in checkout URL)</label>
                <input type="text" name="key" value="{{ old('key') }}" required placeholder="e.g. career-bootcamp"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1.5">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1.5">Description</label>
                <textarea name="description" rows="2"
                    class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">{{ old('description') }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1.5">Price</label>
                    <input type="number" step="0.001" min="0" name="price" value="{{ old('price') }}" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-600 mb-1.5">Currency</label>
                    <input type="text" name="currency" value="{{ old('currency', 'BHD') }}" maxlength="3" required
                        class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm uppercase focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500">
                </div>
            </div>
            <button type="submit" class="w-full bg-brand-700 hover:bg-brand-800 text-white font-semibold py-2.5 rounded-lg transition-colors duration-200">
                Add Product
            </button>
        </form>
    </div>

</div>

@endsection
