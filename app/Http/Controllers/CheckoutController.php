<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    // GET /checkout - Tampilkan form checkout
    public function index()
    {
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();
        
        // Cek apakah cart kosong
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                           ->with('error', 'Keranjang belanja Anda kosong!');
        }
        
        $total = $cartItems->sum(function ($item) {
            return $item->subtotal;
        });
        
        return view('checkout.index', compact('cartItems', 'total', 'user'));
    }
    
    // POST /checkout/process - Proses checkout
    public function process(Request $request)
    {
        // Validasi input
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string|in:transfer_bca,transfer_mandiri,cod,gopay'
        ]);
        
        $user = Auth::user();
        $cartItems = $user->cartItems()->with('product')->get();
        
        // Cek lagi apakah cart kosong (double check)
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                           ->with('error', 'Keranjang belanja Anda kosong!');
        }
        
        // Hitung total
        $total = $cartItems->sum(function ($item) {
            return $item->subtotal;
        });
        
        // Gunakan database transaction untuk keamanan
        DB::transaction(function () use ($request, $user, $cartItems, $total) {
            // 1. Buat order baru
            $order = Order::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $request->payment_method,
                'status' => 'pending'
            ]);
            
            // 2. Pindahkan cart items ke order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price // Snapshot harga
                ]);
            }
            
            // 3. Kosongkan cart
            $user->cartItems()->delete();
        });
        
        return redirect()->route('orders.index')
                       ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
    }
}
