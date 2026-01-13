<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    protected $fillable = [
        'code',
        'discount_type',
        'discount_value',
        'max_uses',
        'current_uses',
        'expiry_date',
        'is_active',
        'description',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Check if promo is valid and can be used
     */
    public function isValid(): bool
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check if expired
        if ($this->expiry_date && $this->expiry_date->isPast()) {
            return false;
        }

        // Check if max uses reached
        if ($this->max_uses && $this->current_uses >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount based on total price
     */
    public function calculateDiscount($totalPrice): float
    {
        // Ensure values are numeric
        $discount = (float) $this->discount_value ?? 0;
        $total = (float) $totalPrice ?? 0;

        if ($total <= 0) {
            return 0.0;
        }

        if ($this->discount_type === 'percentage') {
            return ($total * $discount) / 100;
        }

        // Fixed amount discount
        return (float) min($discount, $total); // Don't discount more than total
    }
}
