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

        // Tap signs the amount rounded to the currency's own decimals: 3 for BHD/KWD/OMR/JOD, 2 for everything else
        // (e.g. "59.00" for SAR, "49.000" for BHD), not PHP's default float-to-string cast (which drops trailing zeros).
        // https://developers.tap.company/docs/webhook
        // previous: $amount = number_format((float) ($payload['amount'] ?? 0), 3, '.', '');   // wrong for SAR/AED/QAR/USD
        $decimals = in_array($payload['currency'] ?? '', ['BHD', 'KWD', 'OMR', 'JOD'], true) ? 3 : 2;
        $amount = number_format((float) ($payload['amount'] ?? 0), $decimals, '.', '');

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
