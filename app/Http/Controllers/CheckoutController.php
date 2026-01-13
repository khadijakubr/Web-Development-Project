<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Promo;
use App\Services\PromoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * GET /checkout - Display checkout form
     */
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product', 'promo')->get();
        
        // Check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                           ->with('error', 'Your shopping cart is empty!');
        }
        
        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->subtotal;
        });
        
        // Get applied promo from first cart item
        $appliedPromo = $cartItems->first()?->promo;
        $discount = 0;
        $finalTotal = $total;
        
        if ($appliedPromo) {
            $discount = $appliedPromo->calculateDiscount($total);
            $finalTotal = $total - $discount;
        }
        
        return view('checkout.index', [
            'cartItems' => $cartItems,
            'total' => $total,
            'discount' => $discount,
            'finalTotal' => $finalTotal,
            'appliedPromo' => $appliedPromo,
            'user' => $user
        ]);
    }

    /**
     * POST /checkout/process - Process the order
     */
    public function process(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'shipping_address' => 'required|string|min:10|max:500',
            'payment_method' => 'required|in:transfer_bca,transfer_mandiri,cod',
            'promo_id' => 'nullable|exists:promos,id'
        ]);
        
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product', 'promo')->get();
        
        // Double check if cart is empty
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                           ->with('error', 'Your shopping cart is empty!');
        }
        
        // Calculate total
        $total = $cartItems->sum(function ($item) {
            return $item->subtotal;
        });
        
        // Get applied promo from cart items or request
        $promo = null;
        $discount = 0;
        $finalTotal = $total;
        
        // Check if promo_id is in request
        if ($request->promo_id) {
            $promo = Promo::find($request->promo_id);
        } 
        // Otherwise, get promo from cart items
        else {
            $promo = $cartItems->first()?->promo;
        }
        
        // Calculate discount if promo exists and is valid
        if ($promo && $promo->isValid()) {
            $discount = $promo->calculateDiscount($total);
            $finalTotal = max(0, $total - $discount);
        }
        
        // Use database transaction for security
        DB::transaction(function () use ($request, $user, $cartItems, $total, $promo, $discount, $finalTotal) {
            // 1. Create new order
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'discount' => $discount,
                'final_price' => $finalTotal,
                'promo_id' => $promo?->id,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'status' => 'pending'
            ]);
            
            // 2. Move cart items to order items
            foreach ($cartItems as $cartItem) {
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price, // Price snapshot
                    'discount' => $cartItem->product->discount // Store product discount percentage
                ]);
            }
            
            // 3. Increment promo usage and check if max uses reached
            if ($promo) {
                $promo->increment('current_uses');
                
                // Auto-disable promo if max uses reached
                if ($promo->max_uses && $promo->current_uses >= $promo->max_uses) {
                    $promo->update(['is_active' => false]);
                }
            }
            
            // 4. Clear cart
            $user->cartItems()->delete();
        });
        
        return redirect()->route('orders.index')
                       ->with('success', 'Order created successfully! Your books will be shipped soon.');
    }
    
    /**
     * POST /checkout/apply-promo - AJAX endpoint to apply promo code
     */
    public function applyPromo(Request $request)
    {
        // Validate input
        $request->validate([
            'promo_code' => 'required|string'
        ]);

        try {
            $promoCode = strtoupper($request->input('promo_code'));
            $user = Auth::user();

            // Get user's cart items
            $cartItems = $user->cartItems()->with('product')->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty'
                ], 400);
            }

            // Find promo by code
            $promo = Promo::where('code', $promoCode)->first();

            if (!$promo) {
                return response()->json([
                    'success' => false,
                    'message' => 'Promo code not found'
                ], 404);
            }

            // Check if promo is valid
            if (!$promo->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Promo code is expired or no longer valid'
                ], 400);
            }

            // Calculate total price from cart
            $totalPrice = $cartItems->sum(function ($item) {
                return $item->subtotal;
            });

            // Calculate discount amount
            $discountAmount = $promo->calculateDiscount($totalPrice);
            $finalTotal = $totalPrice - $discountAmount;

            // Apply promo to all cart items
            foreach ($cartItems as $item) {
                $item->update(['promo_id' => $promo->id]);
            }

            // Increment promo usage and check if max uses reached
            $promo->increment('current_uses');
            
            // Auto-disable promo if max uses reached
            if ($promo->max_uses && $promo->current_uses >= $promo->max_uses) {
                $promo->update(['is_active' => false]);
            }

            return response()->json([
                'success' => true,
                'message' => "'{$promoCode}' applied successfully!",
                'data' => [
                    'promo_code' => $promo->code,
                    'promo_description' => $promo->description,
                    'discount_type' => $promo->discount_type,
                    'discount_value' => $promo->discount_value,
                    'subtotal' => $totalPrice,
                    'discount_amount' => $discountAmount,
                    'final_total' => $finalTotal,
                    'formatted_discount' => 'Rp ' . number_format($discountAmount, 0, ',', '.'),
                    'formatted_final' => 'Rp ' . number_format($finalTotal, 0, ',', '.')
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error applying promo code: ' . $e->getMessage()
            ], 500);
        }
    }
}