<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
    'customer_name',
    'customer_email',
    'address',
    'total',
    'status',
    'payment_status',
    'stripe_session_id',
    'stripe_payment_intent_id',
];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}