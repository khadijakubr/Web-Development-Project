<div class="promo-input-section">
  <div class="form-group">
    <label for="promo-code" class="promo-label">Promo Code</label>
    <div class="promo-input-group">
      <input 
        type="text" 
        id="promo-code" 
        class="promo-input" 
        placeholder="Enter promo code"
        value="{{ $promoCode ?? '' }}"
      >
      <button type="button" class="btn-promo-apply" onclick="applyPromoCode()">
        Apply
      </button>
    </div>
    <div id="promo-message" class="promo-message" style="display: none;"></div>
  </div>
</div>

<!-- Discount Display (Hidden by default) -->
<div id="discount-section" class="discount-section" style="display: none;">
  <div class="summary-row">
    <span class="summary-label discount-label">Discount</span>
    <span class="summary-value discount-value" id="discount-amount">-Rp 0</span>
  </div>
</div>