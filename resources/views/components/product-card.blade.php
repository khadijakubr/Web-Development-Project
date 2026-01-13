<div class="product-card">
    
    <!-- Product Image -->
    <div class="product-image-container">
        <img 
            src="{{ $image ? asset('storage/' . $image) : asset('images/default-book.jpg') }}" 
            alt="{{ $name }}"
            class="product-image"
            loading="lazy">
        
        <!-- Discount Badge (if discount > 0) -->
        @if($discount > 0)
            <div class="discount-badge">
                -{{ $discount }}%
            </div>
        @endif
    </div>
    
    <!-- Product Info: Title, Rating, Price -->
    <div class="product-info">
        
        <!-- Product Title (2-line max) -->
        <a href="{{ route('products.show', $id) }}" class="product-title-link">
            <h3 class="product-title">{{ $name }}</h3>
        </a>
        
        <!-- Star Rating with Average -->
        <div class="product-rating">
            @php
                $product = \App\Models\Product::find($id);
                $avgRating = $product->reviews()->avg('rating');
                $reviewCount = $product->reviews()->count();
            @endphp
            @if($reviewCount > 0)
                <span class="star">★</span>
                <span class="rating-value">{{ number_format($avgRating, 1) }}</span>
                <span class="review-count">({{ $reviewCount }})</span>
            @else
                <span class="star-empty">☆</span>
                <span class="no-reviews-text">No reviews yet</span>
            @endif
        </div>
        
        <!-- Product Price with Discount -->
        @if($discount > 0)
            <div class="price-section">
                <p class="original-price">Rp {{ number_format($price, 0, ',', '.') }}</p>
                <p class="product-price">Rp {{ number_format($price - ($price * $discount / 100), 0, ',', '.') }}</p>
            </div>
        @else
            <p class="product-price">Rp {{ number_format($price, 0, ',', '.') }}</p>
        @endif
        
        <!-- ADD TO CART SECTION -->
        <div class="product-card-footer">
            @auth
                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn-add-cart" title="Add to cart">
                        🛒
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn-add-cart" title="Login to add to cart">
                    🛒
                </a>
            @endauth
            
            <!-- View Details Link -->
            <a href="{{ route('products.show', $id) }}" class="btn-view-details">
                View Details
            </a>
        </div>
    </div>
    
</div>