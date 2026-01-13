<!-- @extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="products-index-container"> -->
  <!-- Page Header -->
  <!-- <div class="products-header">
    <h1 class="products-title">Shop Products</h1>
    <p class="products-subtitle">Browse our curated collection of quality products</p>
  </div>

  <div class="products-layout"> -->
    <!-- Left: Filter Sidebar -->
    <!-- <aside class="products-filter-sidebar">
      <div class="filter-card">
        <h3 class="filter-title">Filters</h3>
        
        <form method="get" action="{{ route('products') }}" class="filter-form"> -->
          <!-- Keep q param when filtering -->
          <!-- <input type="hidden" name="q" value="{{ request('q') }}"> -->
          
          <!-- Category Filter -->
          <!-- <div class="filter-group">
            <label class="filter-label">Category</label>
            <select name="category_id" class="form-select form-select-sm">
              <option value="">All Categories</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div> -->

          <!-- Price Range Filter -->
          <!-- <div class="filter-group">
            <label class="filter-label">Min Price</label>
            <input type="number" name="price_min" class="form-control form-control-sm" value="{{ request('price_min') }}" placeholder="0">
          </div>

          <div class="filter-group">
            <label class="filter-label">Max Price</label>
            <input type="number" name="price_max" class="form-control form-control-sm" value="{{ request('price_max') }}" placeholder="999999">
          </div> -->

          <!-- Sort Filter -->
          <!-- <div class="filter-group">
            <label class="filter-label">Sort By</label>
            <select name="sort" class="form-select form-select-sm">
              <option value="">Default</option>
              <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name (A-Z)</option>
              <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name (Z-A)</option>
              <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
              <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
            </select>
          </div>

          <button type="submit" class="btn btn-primary w-100">Apply Filters</button>
        </form>
      </div>
    </aside> -->

    <!-- Right: Products Grid -->
    <!-- <main class="products-main"> -->
      <!-- Products Grid -->
      <!-- @forelse($products as $product)
        <div class="product-card"> -->
          <!-- Product Image -->
          <!-- <div class="product-card-image">
            @if ($product->image)
              <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
            @else
              <div class="product-image-placeholder">
                📷
              </div>
            @endif
          </div> -->

          <!-- Product Info -->
          <!-- <div class="product-card-body">
            <span class="product-category-badge">{{ $product->category->name ?? 'Uncategorized' }}</span>
            
            <h3 class="product-card-title">{{ $product->name }}</h3>
            
            <p class="product-card-description">{{ Str::limit($product->description, 80) }}</p> -->

            <!-- Price Section -->
            <!-- <div class="product-card-price">
              @if ($product->discount > 0)
                <p class="price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                <p class="price-final">Rp {{ number_format($product->finalPrice(), 0, ',', '.') }}</p>
                <span class="discount-badge">{{ $product->discount }}% off</span>
              @else
                <p class="price-final">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
              @endif
            </div> -->

            <!-- Action Button -->
            <!-- <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-sm w-100">
              View Details
            </a>
          </div>
        </div>
      @empty
        <div class="products-empty">
          <p class="empty-icon">📦</p>
          <p class="empty-text">No products found</p>
          <p class="empty-subtext">Try adjusting your filters</p>
        </div>
      @endforelse
    </main>
  </div> -->

  <!-- Pagination -->
  <!-- @if ($products->count() > 0)
    <div class="products-pagination">
      {{ $products->links() }}
    </div>
  @endif
</div>
@endsection -->
