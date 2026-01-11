<div class="card h-100 shadow-sm position-relative">
  
  {{-- Badge Diskon --}}
  @if ($discount > 0)
    <span class="badge bg-danger position-absolute top-0 start-0 m-2">
      -{{ $discount }}%
    </span>
  @endif

  <div class="ratio ratio-4x5">
    <img 
      src="{{ $image 
        ? asset('storage/' . $image) 
        : asset('images/default-book.jpg') }}"
      class="card-img-top object-fit-cover"
      alt="{{ $name }}">
  </div>

  <div class="card-body d-flex flex-column">
    <h6 class="card-title fw-semibold">{{ $name }}</h6>

    <p class="card-text text-muted small">
      {{ Str::limit($description, 80) }}
    </p>

    <div class="mt-auto">

      {{-- Harga --}}
      @if ($discount > 0)
        <p class="text-muted text-decoration-line-through mb-0">
          Rp {{ number_format($price, 0, ',', '.') }}
        </p>

        <p class="fw-bold text-success mb-2">
          Rp {{ number_format($finalPrice, 0, ',', '.') }}
        </p>
      @else
        <p class="fw-bold mb-2">
          Rp {{ number_format($price, 0, ',', '.') }}
        </p>
      @endif

      <div class="d-flex gap-2">
        <a href="{{ route('products.show', $id) }}"
           class="btn btn-sm btn-outline-primary flex-fill">
          View
        </a>

        @auth
          <form action="{{ route('cart.add') }}" method="POST" class="flex-fill">
            @csrf
            <input type="hidden" name="product_id" value="{{ $id }}">
            <input type="hidden" name="quantity" value="1">
            <button type="submit" class="btn btn-sm btn-primary w-100">
              🛒
            </button>
          </form>
        @else
          <a href="{{ route('login') }}"
             class="btn btn-sm btn-secondary flex-fill">
            Login
          </a>
        @endauth
      </div>
    </div>
  </div>
</div>
