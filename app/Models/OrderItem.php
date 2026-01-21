<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
     protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price'
    ];

    // Relasi: OrderItem belongs to Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi: OrderItem belongs to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Helper method: Hitung subtotal
    public function getSubtotalAttribute()
    {
        return $this->quantity * $this->price;  // Pakai price snapshot!
    }
}
