<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
    ];
}
