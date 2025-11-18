<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Initialize demo products in session (only once)
    private function demoProducts()
    {
        if (!session()->has('products')) {
            $products = [];
            for ($i = 1; $i <= 20; $i++) {
                $products[] = [
                    'id' => $i,
                    'name' => "Product $i",
                    'description' => "Deskripsi singkat produk $i",
                    'price' => rand(10, 500)
                ];
            }
            session(['products' => $products]);
        }
        return session('products');
    }

    // GET /products
    public function index()
    {
        $products = $this->demoProducts();
        return view('products.list', compact('products'));
    }

    // GET /products/create
    public function create()
    {
        return view('products.form', ['action' => route('products.store'), 'product' => null]);
    }

    // GET /products/edit/{id}
    public function edit($id)
    {
        $product = collect($this->demoProducts())->firstWhere('id', (int)$id);
        if (!$product) {
            return redirect()->route('products')->with('error', 'Produk tidak ditemukan.');
        }
        return view('products.form', ['action' => route('products.update', ['id' => $id]), 'product' => $product]);
    }

    // POST /products/store
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $products = $this->demoProducts();
        $newId = count($products) + 1;
        
        $products[] = [
            'id' => $newId,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price']
        ];
        
        session(['products' => $products]);

        return redirect()->route('products')->with('success', 'Produk berhasil disimpan!');
    }

    // POST /products/update/{id}
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        $products = $this->demoProducts();
        $index = collect($products)->search(fn($p) => $p['id'] == (int)$id);

        if ($index === false) {
            return redirect()->route('products')->with('error', 'Produk tidak ditemukan.');
        }

        $products[$index] = [
            'id' => (int)$id,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price']
        ];

        session(['products' => $products]);

        return redirect()->route('products.show', ['id' => $id])->with('success', 'Produk berhasil diupdate!');
    }

    // GET /products/show/{id}
    public function show($id)
    {
        $product = collect($this->demoProducts())->firstWhere('id', (int)$id);
        if (!$product) {
            return redirect()->route('products')->with('error', 'Produk tidak ditemukan.');
        }
        return view('products.show', compact('product'));
    }
}