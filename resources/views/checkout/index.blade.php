@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="checkout-container">
  <!-- Page Header -->
  <div class="checkout-header">
    <h1 class="checkout-title">Checkout</h1>
    <p class="checkout-subtitle">Complete your order</p>
  </div>

  <form action="{{ route('checkout.process') }}" method="POST" class="checkout-form">
    @csrf
    
    <div class="checkout-layout">
      <!-- Main Form Section -->
      <div class="checkout-form-section">
        <!-- Shipping Address Section -->
        <div class="checkout-section">
          <h2 class="section-title">Shipping Address</h2>
          
          <div class="form-group">
            <label for="shipping_address" class="form-label">Complete Address <span class="required">*</span></label>
            <textarea 
              name="shipping_address" 
              id="shipping_address" 
              class="form-control @error('shipping_address') is-invalid @enderror" 
              rows="5" 
              placeholder="Street address, apartment or suite number, city, postal code, and country"
              required>{{ old('shipping_address', $user->address ?? '') }}</textarea>
            @error('shipping_address')
              <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
            <small class="form-text">Ensure your address is complete and accurate for safe delivery.</small>
          </div>
        </div>

        <!-- Coupon/Promo Section -->
        <!-- <div class="checkout-section">
          <h2 class="section-title">Promo Code</h2>
          
          <div class="form-group">
            <label for="promo_code" class="form-label">Have a coupon? Enter it here</label>
            <div class="promo-input-group">
              <input 
                type="text" 
                id="promo_code" 
                name="promo_code" 
                class="form-control" 
                placeholder="Enter promo code"
                value="{{ old('promo_code', $appliedPromo?->code ?? '') }}"
                style="margin-bottom: 10px;">
              <button type="button" class="btn btn-secondary" id="apply-promo-btn">Apply Promo</button>
            </div>
            <div id="promo-message"></div>
            <input type="hidden" name="promo_id" id="promo_id" value="{{ old('promo_id', $appliedPromo?->id ?? '') }}">
          </div>
        </div> -->

        <!-- Payment Method Section -->
        <div class="checkout-section">
          <h2 class="section-title">Payment Method</h2>
          
          <div class="form-group">
            <label class="form-label">Choose Payment Method <span class="required">*</span></label>
            
            <div class="payment-methods">
              <!-- Bank Transfer BCA -->
              <div class="payment-method-option">
                <input 
                  class="form-check-input payment-radio" 
                  type="radio" 
                  name="payment_method" 
                  id="payment_bca" 
                  value="transfer_bca" 
                  {{ old('payment_method') == 'transfer_bca' ? 'checked' : '' }} 
                  required>
                <label class="payment-method-label" for="payment_bca">
                  <span class="payment-method-title">Bank Transfer</span>
                  <span class="payment-method-desc">BCA - Account: 1234567890 (Bookverse)</span>
                </label>
              </div>

              <!-- Bank Transfer Mandiri -->
              <div class="payment-method-option">
                <input 
                  class="form-check-input payment-radio" 
                  type="radio" 
                  name="payment_method" 
                  id="payment_mandiri" 
                  value="transfer_mandiri" 
                  {{ old('payment_method') == 'transfer_mandiri' ? 'checked' : '' }}>
                <label class="payment-method-label" for="payment_mandiri">
                  <span class="payment-method-title">Bank Transfer</span>
                  <span class="payment-method-desc">Mandiri - Account: 0987654321 (Bookverse)</span>
                </label>
              </div>

              <!-- E-Wallet -->
              <!-- <div class="payment-method-option">
                <input 
                  class="form-check-input payment-radio" 
                  type="radio" 
                  name="payment_method" 
                  id="payment_gopay" 
                  value="gopay" 
                  {{ old('payment_method') == 'gopay' ? 'checked' : '' }}>
                <label class="payment-method-label" for="payment_gopay">
                  <span class="payment-method-title">E-Wallet</span>
                  <span class="payment-method-desc">GoPay via the Gojek app</span>
                </label>
              </div> -->

              <!-- Cash on Delivery -->
              <div class="payment-method-option">
                <input 
                  class="form-check-input payment-radio" 
                  type="radio" 
                  name="payment_method" 
                  id="payment_cod" 
                  value="cod" 
                  {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
                <label class="payment-method-label" for="payment_cod">
                  <span class="payment-method-title">Cash on Delivery</span>
                  <span class="payment-method-desc">Pay when your order arrives</span>
                </label>
              </div>
            </div>

            @error('payment_method')
              <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <!-- Order Summary Section -->
      <div class="checkout-summary-section">
        <div class="checkout-summary-card">
          <h2 class="summary-title">Order Summary</h2>

          <!-- Items List -->
          <div class="order-items-list">
            @foreach($cartItems as $item)
              <div class="order-item-row">
                <div class="item-details">
                  <p class="item-name">{{ $item->product->name }}</p>
                  @if($item->discount > 0)
                    <p class="item-qty">{{ $item->quantity }} × Rp {{ number_format($item->product->price - ($item->product->price * $item->discount / 100), 0, ',', '.') }} <span style="text-decoration: line-through; color: #999;">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span></p>
                  @else
                    <p class="item-qty">{{ $item->quantity }} × Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                  @endif
                </div>
                <p class="item-price">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
              </div>
            @endforeach
          </div>

          <!-- Promo Code Component -->
          <x-promo-code-input :promoCode="$cartItems->first()?->promo->code ?? ''" />

          <div class="summary-divider"></div>

          <!-- Subtotal -->
          <div class="order-subtotal">
            <span class="subtotal-label">Subtotal</span>
            <span class="subtotal-value">Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>

          <!-- Discount -->
          @if($discount > 0)
            <div class="order-discount">
              <span class="discount-label">
                Discount
                @if($appliedPromo)
                  ({{ $appliedPromo->discount_type === 'percentage' ? $appliedPromo->discount_value . '%' : 'Rp ' . number_format($appliedPromo->discount_value, 0, ',', '.') }})
                @endif
              </span>
              <span class="discount-value" style="color: #28a745;">-Rp {{ number_format($discount, 0, ',', '.') }}</span>
            </div>
          @endif

          <!-- Total -->
          <div class="order-total">
            <span class="total-label">Total Payment</span>
            <span class="total-value">Rp {{ number_format($finalTotal, 0, ',', '.') }}</span>
          </div>

          <div class="summary-divider"></div>

          <!-- Action Buttons -->
          <div class="checkout-actions">
            <button type="submit" class="btn btn-primary confirm-order-btn">
              Confirm Order
            </button>
            
            <a href="{{ route('cart.index') }}" class="btn btn-secondary back-to-cart-btn">
              Back to Cart
            </a>
          </div>

          <!-- Note -->
          <div class="checkout-note">
            <p><strong>Note:</strong> After confirming, your order will be processed and your cart will be cleared.</p>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection