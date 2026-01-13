<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of promos
     */
    public function index()
    {
        $promos = Promo::latest()->paginate(10);
        return view('admin.promos.index', compact('promos'));
    }

    /**
     * Show the form for creating a new promo
     */
    public function create()
    {
        return view('admin.promos.create');
    }

    /**
     * Store a newly created promo in database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promos,code|uppercase',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'max_uses' => 'nullable|integer|min:1',
            'expiry_date' => 'nullable|date|after:today',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:255',
        ]);

        Promo::create($validated);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo created successfully!');
    }

    /**
     * Show the form for editing the specified promo
     */
    public function edit(Promo $promo)
    {
        return view('admin.promos.edit', compact('promo'));
    }

    /**
     * Update the specified promo in database
     */
    public function update(Request $request, Promo $promo)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promos,code,' . $promo->id . '|uppercase',
            'discount_type' => 'required|in:percentage,fixed',
            'discount_value' => 'required|numeric|min:0.01',
            'max_uses' => 'nullable|integer|min:1',
            'expiry_date' => 'nullable|date|after:today',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:255',
        ]);

        $promo->update($validated);

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo updated successfully!');
    }

    /**
     * Delete the specified promo
     */
    public function destroy(Promo $promo)
    {
        $promo->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo deleted successfully!');
    }
}