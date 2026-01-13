<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name'
        ]);

        // Create slug from name
        $slug = Str::slug($request->name);  
        
        Category::create([
            'name' => $request->name,
            'slug' => $slug  
        ]);

        return redirect()->route('admin.categories.index')
                        ->with('success', 'Kateggori berhasil dibuat!');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id
        ]);

        $category->update(['name' => $request->name]);

        return back()->with('success', 'Kategori diupdate');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return back()->with('success', 'Kategori dihapus');
    }
}
