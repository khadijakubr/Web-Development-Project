<?php

namespace App\Services;

use App\Models\Promo;

class PromoService
{
    /**
     * Validate and apply a promo code
     * Returns array with success status and promo data or error message
     */
    public function validatePromo(string $code): array
    {
        // Check if promo exists
        $promo = Promo::where('code', strtoupper($code))->first();

        if (!$promo) {
            return [
                'success' => false,
                'message' => 'Promo code not found.',
            ];
        }

        // Check if promo is valid
        if (!$promo->isValid()) {
            return [
                'success' => false,
                'message' => $this->getInvalidPromoMessage($promo),
            ];
        }

        return [
            'success' => true,
            'promo' => $promo,
            'message' => 'Promo code applied successfully!',
        ];
    }

    /**
     * Get appropriate error message for invalid promo
     */
    private function getInvalidPromoMessage(Promo $promo): string
    {
        if (!$promo->is_active) {
            return 'This promo code is no longer active.';
        }

        if ($promo->expiry_date && $promo->expiry_date->isPast()) {
            return 'This promo code has expired on ' . $promo->expiry_date->format('M d, Y') . '.';
        }

        if ($promo->max_uses && $promo->current_uses >= $promo->max_uses) {
            return 'This promo code has reached its maximum usage limit.';
        }

        return 'This promo code is not available.';
    }

    /**
     * Calculate discount amount for a given price
     */
    public function calculateDiscount(Promo $promo, float $totalPrice): float
    {
        return $promo->calculateDiscount($totalPrice);
    }

    /**
     * Apply promo to order (increment usage count)
     */
    public function applyPromoToOrder(Promo $promo): void
    {
        $promo->increment('current_uses');
    }

    /**
     * Remove promo from order (decrement usage count)
     */
    public function removePromoFromOrder(Promo $promo): void
    {
        if ($promo->current_uses > 0) {
            $promo->decrement('current_uses');
        }
    }

    /**
     * Get promo details with discount info
     */
    public function getPromoDetails(Promo $promo, float $totalPrice): array
    {
        $discount = $this->calculateDiscount($promo, $totalPrice);

        return [
            'code' => $promo->code,
            'discount_type' => $promo->discount_type,
            'discount_value' => $promo->discount_value,
            'discount_amount' => $discount,
            'final_price' => max(0, $totalPrice - $discount),
        ];
    }
}