<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'totalUsers'    => User::where('role', 'user')->count(),
            'totalOrders'   => Order::count(),
            'latestOrders'  => Order::latest()->take(5)->get(),
        ]);
    }
}
