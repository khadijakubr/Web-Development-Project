import './bootstrap';

// Product Detail Page - Quantity Control
document.addEventListener('DOMContentLoaded', function() {
    const qtyInput = document.getElementById('quantity');
    const increaseBtn = document.querySelector('.qty-increase');
    const decreaseBtn = document.querySelector('.qty-decrease');

    if (increaseBtn) {
      increaseBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const current = parseInt(qtyInput.value);
        if (current < 100) {
          qtyInput.value = current + 1;
        }
      });
    }

    if (decreaseBtn) {
      decreaseBtn.addEventListener('click', function(e) {
        e.preventDefault();
        const current = parseInt(qtyInput.value);
        if (current > 1) {
          qtyInput.value = current - 1;
        }
      });
    }
});

// Cart Page - Quantity Control with Auto-Update
document.addEventListener('DOMContentLoaded', function() {
    const qtyIncreaseButtons = document.querySelectorAll('.qty-increase');
    const qtyDecreaseButtons = document.querySelectorAll('.qty-decrease');
    
    qtyIncreaseButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const input = this.parentElement.querySelector('.quantity-input-cart');
            input.value = parseInt(input.value) + 1;
            updateCartPrice(input);
            submitQuantityForm(input);
        });
    });
    
    qtyDecreaseButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const input = this.parentElement.querySelector('.quantity-input-cart');
            if(parseInt(input.value) > 1) {
                input.value = parseInt(input.value) - 1;
                updateCartPrice(input);
                submitQuantityForm(input);
            }
        });
    });
});

function updateCartPrice(input) {
    const card = input.closest('.cart-item-card');
    const price = parseFloat(input.getAttribute('data-price'));
    const newQuantity = parseInt(input.value);
    const subtotalElement = card.querySelector('.subtotal-value');
    const newSubtotal = price * newQuantity;
    
    subtotalElement.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(newSubtotal));
}

function submitQuantityForm(input) {
    // Find the form associated with this item (need to update cart route form)
    const itemId = input.getAttribute('data-item-id');
    // Create a form and submit it
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = `/cart/update/${itemId}`;
    
    const quantityInput = document.createElement('input');
    quantityInput.type = 'hidden';
    quantityInput.name = 'quantity';
    quantityInput.value = input.value;
    
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    form.appendChild(quantityInput);
    form.appendChild(csrfInput);
    document.body.appendChild(form);
    form.submit();
}