<div class="review-card">
    <!-- User Name -->
    <div class="review-header">
        <strong class="review-user-name">{{ $userName }}</strong>
        <span class="review-date">{{ $createdAt }}</span>
    </div>
    
    <!-- Star Rating -->
    <div class="review-rating">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= $rating)
                <span class="star star-filled">★</span>
            @else
                <span class="star star-empty">☆</span>
            @endif
        @endfor
    </div>
    
    <!-- Comment Text -->
    <div class="review-comment">
        <p>{{ $comment }}</p>
    </div>
</div>
