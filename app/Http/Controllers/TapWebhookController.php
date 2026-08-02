<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

        if ($order && $order->status !== 'paid'){
            $order->update([
                'status' => $payload['status'] === 'CAPTURED' ? 'paid' : 'failed',
                'paid_at' => $payload['status'] === 'CAPTURED' ? now() : null,
            ]);

            if ($order->source === 'career_platform' && $order->status === 'paid') {
                $this->notifyCareerPlatform($order);
            }
        }

        return response()->json(['recieved' => true]);
    }

    private function notifyCareerPlatform(Order $order): void
    {
        $body = json_encode([
            'external_user_id' => $order->external_user_id,
            'order_ref' => $order->external_ref,
            'plan_code' => $order->product_key,
            'amount' => (float) $order->amount,
            'currency' => $order->currency,
            'status' => 'paid',
            'tap_charge_id' => $order->tap_charge_id,
            'paid_at' => $order->paid_at?->toIso8601String(),
        ]);

        $signature = hash_hmac('sha256', $body, config('services.hub.key'));

        try {
            Http::withHeaders(['X-Hub-Signature' => $signature])
                ->withBody($body, 'application/json')
                ->post(config('services.hub.target_url'));
        } catch (\Throwable $e) {
            report($e);
        }
    }
}