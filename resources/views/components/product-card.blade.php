<div class="card h-100">
  <div class="card-body d-flex flex-column">
    <h5 class="card-title">{{ $name }}</h5>
    <p class="card-text">{{ Str::limit($description, 100) }}</p>
    <div class="mt-auto">
      <p class="fw-bold">Rp {{ number_format($price, 0, ',', '.') }}</p>
      
      <div class="d-flex gap-2">
        <a href="{{ route('products.show', $id) }}" class="btn btn-sm btn-outline-primary">View</a>
        
        @auth
          <!-- Tombol Add to Cart (hanya untuk user yang login) -->
          <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
            @csrf
            <input type="hidden" name="product_id" value="{{ $id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-sm btn-primary">🛒 Add to Cart</button>
          </form>
        @else
          <!-- Tombol Login (untuk user yang belum login) -->
          <a href="{{ route('login') }}" class="btn btn-sm btn-primary">Login to Buy</a>
        @endauth
        
      </div>
    </div>
  </div>
</div>
