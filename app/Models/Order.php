<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'discount',
        'final_price',
        'status',
        'promo_id',
        'shipping_address',
        'payment_method',
    ];

    protected $casts = [
        'total_price' => 'decimal:2',
        'discount' => 'decimal:2',
        'final_price' => 'decimal:2',
    ];

    // Relasi: Order belongs to User (1 order punya 1 user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Order has many OrderItems (1 order punya banyak items)
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Get the promo applied to this order
    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }
}
