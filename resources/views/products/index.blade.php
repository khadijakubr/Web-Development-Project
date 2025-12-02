@extends('layouts.app')

@section('content')
<div class="row mb-4">
  <div class="col-md-3">
    <!-- Filter card -->
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Filter</h5>
        <form method="get" action="{{ route('products.index') }}">
          <!-- Keep q param when filtering -->
          <input type="hidden" name="q" value="{{ request('q') }}">
          <div class="mb-3">
            <label>Kategori</label>
            <select name="category_id" class="form-select">
              <option value="">Semua</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label>Harga (min)</label>
            <input type="number" name="price_min" class="form-control" value="{{ request('price_min') }}">
          </div>

          <div class="mb-3">
            <label>Harga (max)</label>
            <input type="number" name="price_max" class="form-control" value="{{ request('price_max') }}">
          </div>

          <div class="mb-3">
            <label>Urutkan</label>
            <select name="sort" class="form-select">
              <option value="">Default</option>
              <option value="name_asc" {{ request('sort')=='name_asc' ? 'selected' : '' }}>Nama A-Z</option>
              <option value="name_desc" {{ request('sort')=='name_desc' ? 'selected' : '' }}>Nama Z-A</option>
              <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Harga Terendah</option>
              <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
            </select>
          </div>

          <button class="btn btn-primary w-100">Terapkan</button>
        </form>
      </div>
    </div>
  </div>

  <div class="col-md-9">
    <!-- Banner / highlight untuk membuat home lebih menarik -->
    <div class="mb-4 p-4 bg-primary text-white rounded">
      <h2>Promo Minggu Ini</h2>
      <p>Temukan produk pilihan dengan harga terbaik!</p>
    </div>

    <!-- Products grid -->
    <div class="row">
      @forelse($products as $product)
        <div class="col-md-4 mb-4">
          <div class="card h-100">
            <img src="{{ $product->image ?? 'https://via.placeholder.com/400x250' }}" class="card-img-top" alt="{{ $product->name }}">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ $product->name }}</h5>
              <p class="card-text text-muted small">{{ $product->category->name ?? '-' }}</p>
              <p class="card-text mb-2">{{ Str::limit($product->description, 80) }}</p>
              <div class="mt-auto d-flex justify-content-between align-items-center">
                <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <div class="alert alert-warning">Produk tidak ditemukan.</div>
        </div>
      @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center">
      {{ $products->links() }}
    </div>
  </div>
</div>
@endsection
