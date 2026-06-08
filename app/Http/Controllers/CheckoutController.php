<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        // For now, support coaching session as a product
        $products = [
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
        
       $productKey = $request->query('product', 'coaching');
       $product = $products[$productKey] ?? $products['coaching'];
       
       return view('checkout.index', compact('product', 'productKey'));
    }

    public function success(Request $request){
        return view('checkout.success');
    }

    public function failed(Request $request){
        return view('checkout.failed');
    }

}