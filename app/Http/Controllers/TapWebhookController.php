<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TapWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->json()->all();
        $secretKey = config('services.tap.secret_key');

        // Tap signs the exact decimal-formatted amount (e.g. "49.000" for BHD),
        // not PHP's default float-to-string cast (which drops trailing zeros to "49").
        $amount = number_format((float) ($payload['amount'] ?? 0), 3, '.', '');

        $toBeHashed = 'x_id' . ($payload['id'] ?? '')
            . 'x_amount' . $amount
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

        $order?->applyTapStatus($payload['status'] ?? '');

        return response()->json(['recieved' => true]);
    }
}
