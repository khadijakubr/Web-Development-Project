/**
 * Promo Code Manager - Fixed Version
 */

window.applyPromoCode = function() {
    const promoInput = document.getElementById('promo-code');
    const promoCode = promoInput.value.trim();
    const messageEl = document.getElementById('promo-message');
    
    // Validate input
    if (!promoCode) {
        showPromoMessage('Please enter a promo code', 'error');
        promoInput.classList.add('promo-input-error');
        return;
    }

    promoInput.classList.remove('promo-input-error');

    // Disable button during request
    const applyBtn = document.querySelector('.btn-promo-apply');
    const originalText = applyBtn.textContent;
    applyBtn.disabled = true;
    applyBtn.textContent = 'Applying...';

    // Send request to apply promo
    fetch('/checkout/apply-promo', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ promo_code: promoCode })
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                throw new Error(data.message || 'Failed to apply promo');
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showPromoMessage(data.message, 'success');
            
            // Update display with discount
            updateCartWithDiscount(data.data);
            
            // Clear input after success
            promoInput.value = '';
        } else {
            showPromoMessage(data.message, 'error');
            promoInput.classList.add('promo-input-error');
        }
    })
    .catch(error => {
        console.error('Promo error:', error);
        showPromoMessage(error.message || 'Error applying promo code', 'error');
        promoInput.classList.add('promo-input-error');
    })
    .finally(() => {
        applyBtn.disabled = false;
        applyBtn.textContent = originalText;
    });
};

/**
 * Update cart/checkout display with discount information
 */
window.updateCartWithDiscount = function(promoData) {
    // Show discount section
    const discountSection = document.getElementById('discount-section');
    if (discountSection) {
        discountSection.style.display = 'block';
        
        const discountAmount = document.getElementById('discount-amount');
        if (discountAmount) {
            discountAmount.textContent = '-' + promoData.formatted_discount;
        }
    }

    // Update total amount
    const totalAmount = document.getElementById('total-amount');
    if (totalAmount) {
        totalAmount.textContent = promoData.formatted_final;
    }

    // Also update SUBTOTAL constant for any calculations
    if (typeof window !== 'undefined') {
        window.SUBTOTAL = promoData.subtotal;
        window.APPLIED_DISCOUNT = promoData.discount_amount;
        window.FINAL_TOTAL = promoData.final_total;
    }

    console.log('Cart updated with promo:', promoData);
};

/**
 * Show promo message to user
 */
window.showPromoMessage = function(message, type = 'info') {
    const messageEl = document.getElementById('promo-message');
    
    if (!messageEl) {
        console.warn('Promo message element not found');
        return;
    }

    // Remove existing classes
    messageEl.className = 'promo-message';
    
    // Add appropriate class based on type
    if (type === 'success') {
        messageEl.classList.add('promo-alert-success');
    } else if (type === 'error') {
        messageEl.classList.add('promo-alert-error');
    } else {
        messageEl.classList.add('promo-alert-info');
    }

    messageEl.textContent = message;
    messageEl.style.display = 'block';

    // Auto-hide after 5 seconds
    setTimeout(() => {
        messageEl.style.display = 'none';
    }, 5000);
};

/**
 * Format price for Indonesian Rupiah display
 */
window.formatPrice = function(price) {
    if (!price || isNaN(price)) return 'Rp 0';
    return 'Rp ' + Math.floor(price).toLocaleString('id-ID');
};