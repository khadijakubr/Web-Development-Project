@extends('layouts.app')

@section('title', 'Edit Review - ' . $product->name)

@section('content')
<div class="review-form-container">
    <!-- Page Header -->
    <div class="review-form-header">
        <a href="{{ route('products.show', $product->id) }}" class="review-back-btn">
            ← Back to Product
        </a>
        <h1 class="review-form-title">Edit Your Review</h1>
        <p class="review-form-subtitle">{{ $product->name }}</p>
    </div>

    <!-- Review Form Card -->
    <div class="review-form-card">
        <form action="{{ route('reviews.update', $review->id) }}" method="POST" class="review-form">
            @csrf
            @method('PUT')

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
                            {{ old('rating', $review->rating) == $i ? 'checked' : '' }}
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
                >{{ old('comment', $review->comment) }}</textarea>
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
                    Update Review
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
