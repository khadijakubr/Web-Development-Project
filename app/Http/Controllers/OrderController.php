<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // GET /orders - Daftar semua pesanan user
    public function index()
    {
        $orders = Auth::user()
                      ->orders()
                      ->with('items.product')
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        
        return view('orders.index', compact('orders'));
    }
    
    // GET /orders/show/{id} - Detail pesanan
    public function show($id)
    {
        // Ambil order milik user yang login
        $order = Order::where('id', $id)
                      ->where('user_id', Auth::id())
                      ->with('items.product')
                      ->firstOrFail();
        
        return view('orders.show', compact('order'));
    }
}
