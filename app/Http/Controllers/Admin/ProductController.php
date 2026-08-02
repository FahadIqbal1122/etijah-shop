<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.index', compact('products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|alpha_dash|max:50|unique:products,key',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['active'] = $request->boolean('active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Product::create($validated);

        return redirect('/admin/products')->with('status', 'Product added.');
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $validated['active'] = $request->boolean('active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $product->update($validated);

        return redirect('/admin/products')->with('status', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/admin/products')->with('status', 'Product removed.');
    }
}
