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
/**
 * Promo Management Functions
 */

/**
 * Check and highlight promos that have reached max uses
 */
function checkPromoMaxUses() {
    const promoRows = document.querySelectorAll('.promos-admin-table tbody tr');
    
    promoRows.forEach(row => {
        const usesCell = row.querySelector('.promo-uses');
        
        if (!usesCell) return;
        
        // Parse uses text like "5 / 10" or "10 / ∞"
        const usesText = usesCell.textContent.trim();
        const parts = usesText.split('/').map(p => p.trim());
        
        if (parts.length === 2) {
            const currentUses = parseInt(parts[0]);
            const maxUses = parts[1];
            
            // Check if max uses is set (not infinity) and reached or exceeded
            if (maxUses !== '∞') {
                const max = parseInt(maxUses);
                
                if (currentUses >= max) {
                    // Add visual indicator class
                    row.classList.add('promo-maxed-out');
                    
                    // Add badge to uses cell
                    const badge = document.createElement('span');
                    badge.className = 'promo-maxed-badge';
                    badge.textContent = 'MAXED OUT';
                    
                    // Remove existing badge if any
                    const existingBadge = usesCell.querySelector('.promo-maxed-badge');
                    if (existingBadge) existingBadge.remove();
                    
                    usesCell.appendChild(badge);
                }
            }
        }
    });
}

/**
 * Validate promo form before submission
 */
function validatePromoForm() {
    const maxUsesInput = document.getElementById('max_uses');
    const currentUsesInput = document.getElementById('current_uses');
    
    if (maxUsesInput && currentUsesInput) {
        const maxUses = parseInt(maxUsesInput.value) || 0;
        const currentUses = parseInt(currentUsesInput.value) || 0;
        
        // Prevent current uses from exceeding max uses
        if (maxUses > 0 && currentUses > maxUses) {
            alert('Current uses cannot exceed max uses!');
            currentUsesInput.value = maxUses;
            return false;
        }
    }
    
    return true;
}

// Run checks on page load
window.addEventListener('load', checkPromoMaxUses);