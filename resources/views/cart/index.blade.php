@extends('layouts.app')

@section('title', 'My Cart')

@section('content')
<div class="cart-container">
  <!-- Page Header -->
  <div class="cart-header">
    <h1 class="cart-title">My Cart</h1>
    @if(!$cartItems->isEmpty())
      <p class="cart-subtitle">{{ $cartItems->count() }} item(s) in your cart</p>
    @endif
  </div>

  @if($cartItems->isEmpty())
    <!-- Empty Cart State -->
    <div class="cart-empty">
      <p class="empty-icon">🛒</p>
      <p class="empty-text">Your cart is empty</p>
      <p class="empty-subtext">Start shopping to add items to your cart</p>
      <a href="{{ route('products') }}" class="btn btn-primary">Start Shopping</a>
    </div>
  @else
    <!-- Cart with Items -->
    <div class="cart-layout">
      <!-- Cart Items Section -->
      <div class="cart-items-section">
        <div class="cart-items-list">
          @foreach($cartItems as $item)
            <div class="cart-item-card">
              <!-- Item Header -->
              <div class="cart-item-header">
                <div class="item-product-info">
                  <h3 class="item-name">{{ $item->product->name }}</h3>
                  <span class="item-category">{{ $item->product->category->name }}</span>
                </div>
                <form action="{{ route('cart.remove', $item->id) }}" method="POST" class="remove-item-form" onsubmit="return confirm('Remove this item from cart?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-remove">Remove</button>
                </form>
              </div>

              <!-- Item Body -->
              <div class="cart-item-body">
                <!-- Price Section -->
                <div class="item-price-section">
                  <span class="price-label">Price</span>
                  @if($item->discount > 0)
                    <div>
                      <span class="original-price" style="text-decoration: line-through; color: #999;">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                      <span class="price-value">Rp {{ number_format($item->product->price - ($item->product->price * $item->discount / 100), 0, ',', '.') }}</span>
                      <span class="discount-badge">-{{ $item->discount }}%</span>
                    </div>
                  @else
                    <span class="price-value">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                  @endif
                </div>

                <!-- Quantity Section -->
                <div class="item-quantity-section">
                  <span class="quantity-label">Quantity</span>
                  <div class="quantity-control-cart">
                    <button type="button" class="qty-btn-cart qty-decrease" data-item-id="{{ $item->id }}">−</button>
                    <input type="number" name="quantity" class="quantity-input-cart" value="{{ $item->quantity }}" min="1" max="100" data-item-id="{{ $item->id }}" data-price="{{ $item->product->price }}" readonly>
                    <button type="button" class="qty-btn-cart qty-increase" data-item-id="{{ $item->id }}">+</button>
                  </div>
                </div>

                <!-- Subtotal Section -->
                <div class="item-subtotal-section">
                  <span class="subtotal-label">Subtotal</span>
                  <span class="subtotal-value" data-item-id="{{ $item->id }}">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      <!-- Cart Summary Section -->
      <div class="cart-summary-section">
        <div class="cart-summary-card">
          <h2 class="summary-title">Order Summary</h2>
          
          <div class="summary-details">
            <div class="summary-row">
              <span class="summary-label">Items</span>
              <span class="summary-value">{{ $cartItems->sum('quantity') }}</span>
            </div>
            
            <div class="summary-row">
              <span class="summary-label">Subtotal</span>
              <span class="summary-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>

            <!-- Promo Code Component -->
            <x-promo-code-input :promoCode="$cartItems->first()?->promo->code ?? ''" />
          </div>

          <div class="summary-divider"></div>

          <div class="summary-row summary-total">
            <span class="summary-label">Total</span>
            <span class="summary-value" id="total-amount">
              Rp {{ number_format($total, 0, ',', '.') }}
            </span>
          </div>

          <button class="btn btn-primary checkout-btn" onclick="window.location.href='{{ route('checkout.index') }}'">
            Proceed to Checkout
          </button>
          
          <a href="{{ route('products') }}" class="btn btn-secondary continue-shopping-btn">
            Continue Shopping
          </a>
        </div>
      </div>
    </div>
  @endif
</div>

<!-- Store total price in data attribute for JS -->
<script>
  const SUBTOTAL = {{ $total }};
</script>
@vite(['resources/js/promo.js'])
@endsection