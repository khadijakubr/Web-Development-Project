@if($promo && $promo->id)
    <!-- Promo Applied Box -->
    <div style="margin: 15px 0; padding: 12px; background: #d4edda; border-radius: 5px; border-left: 4px solid #28a745;">
        <p style="margin: 0 0 8px 0; font-size: 0.95rem; color: #155724;">
            <strong>✓ Promo Applied</strong>
        </p>
        <p style="margin: 0 0 8px 0; color: #155724;">
            <strong>Code:</strong> {{ $promo->code }}
        </p>
        <p style="margin: 0; color: #155724;">
            <strong>Type:</strong> 
            @if($promo->discount_type === 'percentage')
                {{ $promo->discount_value }}% Discount
            @else
                Rp {{ number_format($promo->discount_value, 0, ',', '.') }} Discount
            @endif
        </p>
    </div>

    <!-- Discount Amount Row -->
    <div class="summary-row" style="color: #28a745; font-weight: bold;">
        <span class="summary-label">Discount Applied</span>
        <span class="summary-value">-Rp {{ number_format($discountAmount, 2) }}</span>
    </div>
@endif
