<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\TapPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HubOrderController extends Controller
{
    public function store(Request $request)
    {
        if ($request->bearerToken() !== config('services.hub.key')) {
            abort(401);
        }

        $request->validate([
            'first_name'=>'required|string|max:100',
            'last_name'=>'required|string|max:100',
            'email'=>'required|email|max:200',
            'plan_code'=>'required|string|max:100',
            'plan_name'=>'required|string|max:200',
            'amount'=>'required|numeric|min:0',
            'currency'=>'required|string|max:10',
            'return_url'=>'required|url',
        ]);

        $order = Order::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'product_key' => $request->plan_code,
            'product_name' => $request->plan_name,
            'amount' => $request->amount,
            'currency' => $request->currency,
            'status' => 'pending',
            'source' => 'career_platform',
            'external_user_id' => $request->external_user_id,
            'external_ref' => Str::uuid(),
            'return_url' => $request->return_url,
        ]);

        try {
            $charge = app(TapPaymentService::class)->createCharge(
                $order,
                redirectUrl: route('checkout.tap.callback'),
                webhookUrl: route('webhook.tap'),
            );

            $order->update(['tap_charge_id' => $charge['id']]);

            return response()->json([
                'checkout_url' => $charge['transaction']['url'],
                'order_ref' => $order->external_ref,
            ]);
        } catch (\Throwable $e) {
            $order->update(['status' => 'failed']);
            report($e);

            return response()->json(['error' => 'Could not create charge'], 502);
        }
    }
}
