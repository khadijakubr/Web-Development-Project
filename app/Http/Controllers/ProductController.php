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
        return view('products.show', compact('product'));
    }
}