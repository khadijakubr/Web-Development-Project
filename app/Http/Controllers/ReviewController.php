<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Display the form to create a new review for a product
     */
    public function create(Order $order, Product $product)
    {
        // Check if user owns the order
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Check if order status is completed
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'You can only review completed orders.');
        }

        // Check if product is in the order
        $orderItem = $order->items()->where('product_id', $product->id)->first();
        if (!$orderItem) {
            return redirect()->back()->with('error', 'This product is not in your order.');
        }

        // Check if user has already reviewed this product in this order
        $existingReview = Review::where([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
        ])->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product for this order.');
        }

        return view('reviews.create', compact('order', 'product'));
    }

    /**
     * Store a newly created review in storage
     */
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $order = Order::find($validated['order_id']);
        $product = Product::find($validated['product_id']);

        // Check if user owns the order
        if ($order->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Check if order status is completed
        if ($order->status !== 'completed') {
            return redirect()->back()->with('error', 'You can only review completed orders.');
        }

        // Check if product is in the order
        $orderItem = $order->items()->where('product_id', $product->id)->first();
        if (!$orderItem) {
            return redirect()->back()->with('error', 'This product is not in your order.');
        }

        // Check if user has already reviewed this product in this order
        $existingReview = Review::where([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'order_id' => $order->id,
        ])->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already reviewed this product for this order.');
        }

        // Create the review
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $validated['product_id'],
            'order_id' => $validated['order_id'],
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? '',
        ]);

        return redirect()->route('products.show', $product->id)
            ->with('success', 'Your review has been posted successfully!');
    }

    /**
     * Display the form to edit an existing review
     */
    public function edit(Review $review)
    {
        // Check if user owns the review
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        $product = $review->product;
        $order = $review->order;

        return view('reviews.edit', compact('review', 'product', 'order'));
    }

    /**
     * Update the review in storage
     */
    public function update(Request $request, Review $review)
    {
        // Check if user owns the review
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Unauthorized access.');
        }

        // Validate input
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        // Update the review
        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? '',
        ]);

        return redirect()->route('products.show', $review->product_id)
            ->with('success', 'Your review has been updated successfully!');
    }
}
