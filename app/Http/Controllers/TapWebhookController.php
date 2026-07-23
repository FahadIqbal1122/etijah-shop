<?php

namespace App\Http\Controllers;

use App\Models\Order;
Use Illuminate\Http\Request;

class TapWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->json()->all();
        $secretKey = config('services.tap.secret_key');

        $toBeHashed = 'x_id' . ($payload['id'] ?? '')
            . 'x_amount' . ($payload['amount'] ?? '')
            . 'x_currency' . ($payload['currency'] ?? '')
            . 'x_gateway_reference' . ($payload['reference']['gateway'] ?? '')
            . 'x_payment_reference' . ($payload['reference']['payment'] ?? '')
            . 'x_status' . ($payload['status'] ?? '')
            . 'x_created' . ($payload['transaction']['created'] ?? '');

        $expected = hash_hmac('sha256', $toBeHashed, $secretKey);

        if (!hash_equals($expected, $request->header('hashstring', ''))) {
            abort(401, 'Invalid signature');
        }

        $order = Order::where('tap_charge_id', $payload['id'])->first();

        if ($order && $order->status !== 'paid'){
            $order->update([
                'status' => $payload['status'] === 'CAPTURED' ? 'paid' : 'failed',
                'paid_at' => $payload['status'] === 'CAPTURED' ? now() : null,
            ]);
        }

        return response()->json(['recieved' => true]);
    }
}