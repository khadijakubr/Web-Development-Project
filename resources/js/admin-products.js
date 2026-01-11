/**
 * Admin Product Form Functions
 */

function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `
                <img src="${e.target.result}" class="image-preview img-fluid">
            `;
        };
        reader.readAsDataURL(file);
    }
}

function calculateDiscount() {
    const price = parseFloat(document.getElementById('price').value) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    
    if (price > 0) {
        const discountAmount = price * (discount / 100);
        const finalPrice = price - discountAmount;
        
        document.getElementById('finalPrice').textContent = 
            'Rp ' + finalPrice.toLocaleString('id-ID', { maximumFractionDigits: 0 });
    } else {
        document.getElementById('finalPrice').textContent = 'Rp 0';
    }
}

// Calculate on page load
window.addEventListener('load', calculateDiscount);
