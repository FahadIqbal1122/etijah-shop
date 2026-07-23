<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class TapPaymentService
{
    private string $secretKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->secretKey = config('services.tap.secret_key');
        $this->baseUrl = rtrim(config('services.tap.base_url'), '/');
    }

    public function createCharge(Order $order, string $redirectUrl, string $webhookUrl): array
    {
        $response = Http::withToken($this->secretKey)
            ->post("{$this->baseUrl}/charges", [
                'amount' => (float) $order->amount,
                'currency' => $order->currency,
                'threeDSecure' => true,
                'save_card' => false,
                'description' => $order->product_name,
                'statement_descriptor' => 'Etijah Coaching',
                'reference' => [
                    'order' => (string) $order->id,
                ],
                'metadata' => [
                    'order_id' => (string) $order->id,
                ],
                'customer' => [
                    'first_name' => $order->first_name,
                    'last_name' => $order->last_name,
                    'email' => $order->email,                
                ],
                'source' => ['id' => 'src_all'],
                'redirect' => ['url' => $redirectUrl],
                'post' => ['url' => $webhookUrl],
            ]);

        if ($response->failed()) {
            throw new RuntimeException('Tap charge creation failed: ' . $response->body());
        }

        return $response->json();
    }

    public function retrieveCharge(string $chargeId): array
    {
        $response = Http::withToken($this->secretKey)
            ->get("{$this->baseUrl}/charges/{$chargeId}");

        if ($response->failed()) {
            throw new RuntimeException('Tap charge retrieval failed: ' . $response->body());
        }

        return $response->json();
    }
}
