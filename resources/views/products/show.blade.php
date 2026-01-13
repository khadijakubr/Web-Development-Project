@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="product-detail-container">
  <!-- Header -->
  <div class="product-detail-header">
    <a href="{{ route('products') }}" class="product-back-btn">
      ← Back to Products
    </a>
  </div>

  <!-- Main Layout -->
  <div class="product-detail-layout">
    <!-- Left: Product Image -->
    <div class="product-image-section">
      <div class="product-image-wrapper">
        @if ($product->image)
          <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image" />
        @else
          <div class="product-image-placeholder">
            📷 Product Image
          </div>
        @endif
      </div>
    </div>

    <!-- Right: Product Details -->
    <div class="product-details-section">
      <!-- Category Badge -->
      <span class="product-category">{{ $product->category->name }}</span>

      <!-- Product Name -->
      <h1 class="product-name">{{ $product->name }}</h1>

      <!-- Price Section -->
      <div class="product-price-section">
        @if ($product->discount > 0)
          <p class="product-price-original">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </p>
          <p class="product-price-current">
            Rp {{ number_format($product->finalPrice(), 0, ',', '.') }}
          </p>
          <span class="product-discount-badge">
            Save {{ $product->discount }}%
          </span>
        @else
          <p class="product-price-current">
            Rp {{ number_format($product->price, 0, ',', '.') }}
          </p>
        @endif
      </div>

      <!-- Description -->
      <div>
        <p class="product-description-label">Product Description</p>
        <p class="product-description">{{ $product->description }}</p>
      </div>

      <!-- Add to Cart Section -->
      @auth
        <div class="product-cart-section">
          <form action="{{ route('cart.add') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">

            <div class="quantity-control-product">
              <label class="quantity-label">Quantity</label>
              <div class="quantity-input-wrapper">
                <button type="button" class="qty-decrease">−</button>
                <input type="number" name="quantity" id="quantity" value="1" min="1" max="100">
                <button type="button" class="qty-increase">+</button>
              </div>
            </div>

            <button type="submit" class="btn btn-primary add-to-cart-btn">
              🛒 Add to Cart
            </button>
          </form>
        </div>
      @else
        <div class="product-login-cta">
          <p>Please login to purchase this product</p>
          <a href="{{ route('login') }}" class="btn btn-primary">Login Now</a>
        </div>
      @endauth

      <!-- Product Info -->
      <div class="product-info-section">
        <h5 class="product-info-title">Product Information</h5>
        <table class="product-info-table">
          <tr>
            <td>Category</td>
            <td>{{ $product->category->name }}</td>
          </tr>
          <tr>
            <td>Original Price</td>
            <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
          </tr>
          <tr>
            <td>Added</td>
            <td>{{ $product->created_at->format('d M Y') }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection