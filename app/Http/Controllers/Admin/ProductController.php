<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // LIST produk (table admin)
    public function index()
    {
        return view('admin.products.index', [
            'products' => Product::with('category')->latest()->paginate(10)
        ]);
    }

    // FORM tambah produk
    public function create()
    {
        return view('admin.products.create', [
            'categories' => Category::all()
        ]);
    }

    // SIMPAN produk
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'discount' => 'nullable|integer|min:0|max:100',
        ], [
            'name.required' => 'Product name is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be at least 0',
            'category_id.required' => 'Please select a category',
            'category_id.exists' => 'Selected category does not exist',
            'image.image' => 'The file must be an image',
            'image.mimes' => 'Image must be JPG, JPEG, or PNG',
            'image.max' => 'Image size must not exceed 2MB',
            'discount.integer' => 'Discount must be a whole number',
            'discount.min' => 'Discount cannot be less than 0%',
            'discount.max' => 'Discount cannot exceed 100%',
        ]);

        // Upload image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')
                ->store('products', 'public');
        }

        Product::create($validated);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil dibuat!');
    }

    // FORM edit
    public function edit(Product $product)
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    // UPDATE produk
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'discount' => 'nullable|integer|min:0|max:100',
        ], [
            'name.required' => 'Product name is required',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be at least 0',
            'category_id.required' => 'Please select a category',
            'category_id.exists' => 'Selected category does not exist',
            'image.image' => 'The file must be an image',
            'image.mimes' => 'Image must be JPG, JPEG, or PNG',
            'image.max' => 'Image size must not exceed 2MB',
            'discount.integer' => 'Discount must be a whole number',
            'discount.min' => 'Discount cannot be less than 0%',
            'discount.max' => 'Discount cannot exceed 100%',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product berhasi diperbarui!');
    }

    // HAPUS produk
    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $productName = $product->name;
        $product->delete();

        return back()->with('success', "Produk '{$productName}' berhasil dihapus!");
    }
}
