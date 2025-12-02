<form method="GET" action="{{ $action }}" class="mb-4">
  <div class="row g-3">
    
    <!-- Filter Kategori -->
    <div class="col-md-4">
      <select name="category_id" class="form-control">
        <option value="">All Categories</option>
        @foreach($categories as $category)
          <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
          </option>
        @endforeach
      </select>
    </div>
    
    <!-- Filter Harga Min/Max -->
    <div class="col-md-2">
      <input type="number" name="price_min" class="form-control" placeholder="Min Price" value="{{ request('price_min') }}">
    </div>
    <div class="col-md-2">
      <input type="number" name="price_max" class="form-control" placeholder="Max Price" value="{{ request('price_max') }}">
    </div>
    
    <!-- Sorting -->
    <div class="col-md-3">
      <select name="sort" class="form-control">
        <option value="">Default Sort</option>
        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Name A-Z</option>
        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price Low-High</option>
        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High-Low</option>
      </select>
    </div>
    
    <!-- Tombol -->
    <div class="col-md-1">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
  </div>
  
  @if(request()->hasAny(['q', 'category_id', 'price_min', 'price_max', 'sort']))
    <div class="mt-2">
      <a href="{{ $action }}" class="btn btn-sm btn-secondary">Clear Filters</a>
    </div>
  @endif
</form>