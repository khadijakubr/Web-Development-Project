<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
 protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'discount',
        'promo_id', 
    ];

    protected $casts = [
        'discount' => 'decimal:2',
    ];

    /**
     * Get the user that owns the cart item
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product in the cart item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the promo applied to this cart item
     */
    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class)->withDefault();
    }

    public function getSubtotalAttribute()
    {
        $price = $this->product->price;
        $discountedPrice = $price - ($price * $this->discount / 100);
        return $discountedPrice * $this->quantity;
    }
}
