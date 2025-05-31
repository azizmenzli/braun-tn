<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentTransaction extends Model
{
    protected $fillable = [
        'red_order',
        'order_id',
        'amount',
        'currency',
        'status',
        'payment_method',
        'transaction_id',
        'payment_url',
        'payment_details',
        'paid_at'
    ];

    protected $casts = [
        'payment_details' => 'array',
        'paid_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    // Relation avec la commande
    public function order()
    {
        return $this->belongsTo(Order::class, 'red_order', 'red_order');
    }
} 