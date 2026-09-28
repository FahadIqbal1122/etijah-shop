<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class Order extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'product_key',
        'product_name',
        'amount',
        'currency',
        'payment_method',
        'status',
        'notes',
        'source',
        'external_user_id',
        'external_ref',
        'return_url',
        'tap_charge_id',
        'paid_at',
        'failure_reason',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    /**
     * Apply a Tap charge status. Called from both the redirect callback and the
     * webhook, whichever arrives first; the career platform is notified exactly
     * once, when the order first becomes paid.
     */
    public function applyTapStatus(string $tapStatus): void
    {
        $paid = $tapStatus === 'CAPTURED';

        $changed = static::whereKey($this->id)
            ->where('status', '!=', 'paid')
            ->update([
                'status' => $paid ? 'paid' : 'failed',
                'paid_at' => $paid ? now() : null,
            ]);

        $this->refresh();

        if ($paid && $changed && $this->source === 'career_platform') {
            $this->notifyCareerPlatform();
        }
    }

    private function notifyCareerPlatform(): void
    {
        try {
            $body = json_encode([
                'external_user_id' => $this->external_user_id,
                'order_ref' => $this->external_ref,
                'plan_code' => $this->product_key,
                'amount' => (float) $this->amount,
                'currency' => $this->currency,
                'status' => 'paid',
                'tap_charge_id' => $this->tap_charge_id,
                'paid_at' => $this->paid_at?->toIso8601String(),
            ]);

            $signature = hash_hmac('sha256', $body, config('services.hub.key'));

            Http::withHeaders(['X-Hub-Signature' => $signature])
                ->withBody($body, 'application/json')
                ->post(config('services.hub.target_url'))
                ->throw();
        } catch (\Throwable $e) {
            report($e);
        }
    }
}
