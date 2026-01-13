@extends('layouts.app')

@section('title', 'Write Review - ' . $product->name)

@section('content')
<div class="review-form-container">
    <!-- Page Header -->
    <div class="review-form-header">
        <a href="{{ route('products.show', $product->id) }}" class="review-back-btn">
            ← Back to Product
        </a>
        <h1 class="review-form-title">Write a Review</h1>
        <p class="review-form-subtitle">{{ $product->name }}</p>
    </div>

    <!-- Review Form Card -->
    <div class="review-form-card">
        <form action="{{ route('reviews.store') }}" method="POST" class="review-form">
            @csrf

            <!-- Hidden Fields -->
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="order_id" value="{{ $order->id }}">

            <!-- Star Rating Input -->
            <div class="form-group rating-group">
                <label for="rating" class="form-label">Rating</label>
                <div class="star-rating-input">
                    @for ($i = 5; $i >= 1; $i--)
                        <input 
                            type="radio" 
                            id="star{{ $i }}" 
                            name="rating" 
                            value="{{ $i }}"
                            class="star-input"
                            {{ old('rating') == $i ? 'checked' : '' }}
                        >
                        <label for="star{{ $i }}" class="star-label">
                            ★
                        </label>
                    @endfor
                </div>
                @error('rating')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Comment Textarea -->
            <div class="form-group">
                <label for="comment" class="form-label">Your Review (Optional)</label>
                <textarea 
                    id="comment" 
                    name="comment" 
                    class="form-textarea @error('comment') is-invalid @enderror"
                    placeholder="Share your experience with this product..."
                    rows="6"
                >{{ old('comment') }}</textarea>
                @error('comment')
                    <div class="input-error">{{ $message }}</div>
                @enderror
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-secondary">
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    Post Review
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
