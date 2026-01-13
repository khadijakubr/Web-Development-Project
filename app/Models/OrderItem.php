<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
     protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
        'discount'
    ];

    protected $appends = ['subtotal', 'product_discounted_price'];

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

    // Helper method: Get discounted price
    public function getDiscountedPriceAttribute()
    {
        $price = $this->price;
        $discount = $this->discount ?? 0;  // Default to 0 if null
        
        if ($discount > 0) {
            $discountAmount = ($price * $discount) / 100;
            return $price - $discountAmount;
        }
        
        return $price;  // Return original price if no discount
    }

    // Helper method: Get product's actual discounted price from books table
    public function getProductDiscountedPriceAttribute()
    {
        if (!$this->product) {
            return $this->price;
        }
        
        $productPrice = $this->product->price ?? $this->price;
        $productDiscount = $this->product->discount ?? 0;
        
        if ($productDiscount > 0) {
            return $productPrice - ($productPrice * $productDiscount / 100);
        }
        
        return $productPrice;
    }

    // Helper method: Calculate subtotal with product discount applied
    
    public function getSubtotalAttribute()
    {
        $price = $this->price;
        $discount = $this->discount ?? 0;
        
        // Calculate discounted price
        $discountedPrice = $price;
        if ($discount > 0) {
            $discountedPrice = $price - ($price * $discount / 100);
        }
        
        // Return discounted price * quantity
        return $discountedPrice * $this->quantity;
    }
}
