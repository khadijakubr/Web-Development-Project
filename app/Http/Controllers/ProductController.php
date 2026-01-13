<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;    
use App\Models\Category;

class ProductController extends Controller
{
    // GET /products
    public function index(Request $request)
    {
        // Ambil semua kategori untuk filter
        $categories = Category::all();

        // Mulai query produk dengan relasi kategori
        $query = Product::with('category');

        // Cari berdasarkan nama atau deskripsi
        if ($search = $request->input('q')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter kategori 
        if ($categoryId = $request->input('category_id')) {
            $query->where('category_id', $categoryId);
        }

        // Filter range harga
        if (!is_null($request->input('price_min'))) {
            $query->where('price', '>=', $request->input('price_min'));
        }
        if (!is_null($request->input('price_max'))) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Sorting
        switch ($request->input('sort')) {
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest(); // urut default: newest
        }

        // Pagination (12 item per halaman) dan jaga query string di link paginasi
        $products = $query->paginate(12)->appends($request->all());
        return view('products.list', compact('products', 'categories'));
    }

    // GET /products/show/{id}
    public function show($id)
    {
        $product = Product::with('category')->find($id);
        if (!$product) {
            return redirect()->route('products.index')->with('error', 'Produk tidak ditemukan.');
        }
        
        // Load reviews with pagination (2 per page)
        $reviews = $product->reviews()
            ->with('user')
            ->latest()
            ->paginate(2, ['*'], 'review_page');
        
        // Calculate average rating
        $averageRating = $product->reviews()->avg('rating');
        $totalReviews = $product->reviews()->count();
        
        // Check if user has completed orders with this product (for write review button)
        $completedOrderWithProduct = null;
        $userReview = null;
        
        if (auth()->check()) {
            $completedOrderWithProduct = auth()->user()->orders()
                ->where('status', 'completed')
                ->whereHas('items', function($q) use ($product) {
                    $q->where('product_id', $product->id);
                })
                ->first();
            
            // Check if user already reviewed this product
            if ($completedOrderWithProduct) {
                $userReview = $product->reviews()
                    ->where('user_id', auth()->id())
                    ->where('order_id', $completedOrderWithProduct->id)
                    ->first();
            }
        }
        
        return view('products.show', compact(
            'product',
            'reviews',
            'averageRating',
            'totalReviews',
            'completedOrderWithProduct',
            'userReview'
        ));
    }
}