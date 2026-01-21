<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_address',
        'payment_method',
        'status'
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
}
