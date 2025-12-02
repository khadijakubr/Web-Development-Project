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

    // GET /products/create
    public function create()
    {
                $categories = Category::all();

        return view('products.form', [
            'action' => route('products.store'),
            'product' => null,
            'categories' => $categories
        ]);
    }

    // GET /products/edit/{id}
    public function edit($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return redirect()->route('products')->with('error', 'Produk tidak ditemukan.');
        }

        $categories = Category::all();

        return view('products.form', [
            'action' => route('products.update', ['id' => $id]),
            'product' => $product,
            'categories' => $categories
        ]);
    }

    // POST /products/store
    public function store(Request $request)
    {
        // Validasi input
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Buat produk baru lewat Eloquent
        $product = Product::create($data);

        // Redirect ke halaman daftar atau show produk dengan pesan sukses
        return redirect()->route('products')->with('success', 'Produk berhasil disimpan!');
    }

    // POST /products/update/{id}
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product = Product::find($id);
        if (!$product) {
            return redirect()->route('products')->with('error', 'Produk tidak ditemukan.');
        }

        $product->update($data);

        return redirect()->route('products.show', ['id' => $product->id])->with('success', 'Produk berhasil diupdate!');
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