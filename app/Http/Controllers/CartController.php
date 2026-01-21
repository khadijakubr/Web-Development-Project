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
        // Validasi input
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $product = Product::findOrFail($request->product_id);
        
        // Cek apakah produk sudah ada di cart user ini
        $cartItem = CartItem::where('user_id', Auth::id())
                            ->where('product_id', $product->id)
                            ->first();
        
        if ($cartItem) {
            // Kalau sudah ada, tambahkan quantity
            $cartItem->quantity += $request->quantity;
            $cartItem->save();
        } else {
            // Kalau belum ada, buat cart item baru
            CartItem::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $request->quantity
            ]);
        }
        
        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
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
        
        return redirect()->back()->with('success', 'Quantity berhasil diupdate!');
    }
    
    // DELETE /cart/remove/{id} - Hapus item dari cart
    public function remove($id)
    {
        // Cari cart item milik user yang sedang login
        $cartItem = CartItem::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();
        
        $cartItem->delete();
        
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}
