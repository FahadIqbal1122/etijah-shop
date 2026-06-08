<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    private array $products = [
        'coaching' => [
            'name' => 'Coaching Session',
            'description' => '1-on-1 coaching session',
            'price' => '60.000',
            'currency' => 'BHD',
            ],
            'ufuq' => [
                'name' => 'Ufuq Career Assessment',
                'description' => 'Comprehensive career assessment and guidance report',
                'price' => '25.000', // placeholder
                'currency' => 'BHD',
            ],
        ];
        
    public function show(Request $request)
    {
        $productKey = $request->query('product', 'coaching');
        $product = $this->products[$productKey] ?? $this->products['coaching'];
        
        return view('checkout.index', compact('product', 'productKey'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:200',
            'phone' => 'nullable|string|max:30',
            'product_key' => 'required|string',
            'payment_method' => 'required|in:cod',
            'notes' => 'nullable|string|max:1000'
        ]);

        $productKey = $request->product_key;
        $product = $this->products[$productKey] ?? $this->products['coaching'];

        Order::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'product_key' => $productKey,
            'product_name' => $product['name'],
            'amount' => $product['price'],
            'currency' => $product['currency'],
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        return redirect('/checkout/success');
    }

    public function success(Request $request){
        return view('checkout.success');
    }

    public function failed(Request $request){
        return view('checkout.failed');
    }

}