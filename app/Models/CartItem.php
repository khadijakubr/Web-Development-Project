<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity'
    ];

    // Relasi: CartItem belongs to User (1 cart item punya 1 user)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: CartItem belongs to Product (1 cart item punya 1 produk)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper method: Hitung subtotal untuk item ini
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->product->price;
    }
}
