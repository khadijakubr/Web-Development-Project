<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // GET /cart - Tampilkan halaman keranjang belanja
    public function index()
    {
        // Ambil semua cart items user yang sedang login
        $cartItems = Auth::user()->cartItems()->with('product')->get();
        
        // Hitung total harga
        $total = $cartItems->sum(function ($item) {
            return $item->subtotal;
        });
        
        return view('cart.index', compact('cartItems', 'total'));
    }
    
    // POST /cart/add - Tambah produk ke keranjang
    public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($validated['product_id']);
        $discount = $product->discount ?? 0;  // ← Get discount from product

        $cartItem = CartItem::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $validated['quantity'];
            $cartItem->discount = $discount;  // ← Update discount
            $cartItem->save();
        } else {
            CartItem::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'discount' => $discount,  // ← Store discount
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart!');
    }
    
    // POST /cart/update/{id} - Update quantity item di cart
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);
        
        // Cari cart item milik user yang sedang login
        $cartItem = CartItem::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        
        return redirect()->back();
    }
    
    // DELETE /cart/remove/{id} - Hapus item dari cart
    public function remove($id)
    {
        // Cari cart item milik user yang sedang login
        $cartItem = CartItem::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        $cartItem->delete();
        
        return redirect()->back();
    }
}
