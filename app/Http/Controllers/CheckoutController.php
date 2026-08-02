<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\TapPaymentService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function show(Request $request)
    {
        $productKey = $request->query('product', 'coaching');
        $product = Product::where('key', $productKey)->where('active', true)->first()
            ?? Product::where('active', true)->orderBy('sort_order')->firstOrFail();
        $productKey = $product->key;

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
            'payment_method' => 'required|in:cod,tap',
            'notes' => 'nullable|string|max:1000'
        ]);

        $product = Product::where('key', $request->product_key)->where('active', true)->firstOrFail();

        $order = Order::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'product_key' => $product->key,
            'product_name' => $product->name,
            'amount' => $product->price,
            'currency' => $product->currency,
            'payment_method' => $request->payment_method,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        if ($request->payment_method === 'tap') {
            try {
                $charge = app(TapPaymentService::class)->createCharge(
                    $order,
                    redirectUrl: route('checkout.tap.callback'),
                    webhookUrl: route('webhook.tap'),
                );

                $order->update(['tap_charge_id' => $charge['id']]);

                return redirect()->away($charge['transaction']['url']);
            } catch (\Throwable $e) {
                $order->update(['status' => 'failed']);
                report($e);

                return redirect('/checkout/failed');
            }
        }

        return redirect('/checkout/success');
    }

    public function tapCallback(Request $request, TapPaymentService $tap)
    {
        $tapId = $request->query('tap_id');
        $order = Order::where('tap_charge_id', $tapId)->firstOrFail();

        // Never trust the redirect query params alone — verify the real status via the API.
        $charge = $tap->retrieveCharge($tapId);
        $paid = $charge['status'] === 'CAPTURED';

        $order->update([
            'status' => $paid ? 'paid' : 'failed',
            'paid_at' => $paid ? now() : null,
        ]);

        if ($order->return_url) {
            return redirect()-> away($order->return_url . '?order_ref=' . $order->external_ref . '&status=' . ($paid ? 'paid' : 'failed'));
        }
        return redirect($paid ? '/checkout/success' : '/checkout/failed');
    }

    public function success(Request $request){
        return view('checkout.success');
    }

    public function failed(Request $request){
        return view('checkout.failed');
    }

}