@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-body">
        <h1>{{ $product->name }}</h1>
        <p class="text-muted">Kategori: {{ $product->category->name }}</p>
        
        <hr>
        
        <h4>Deskripsi</h4>
        <p>{{ $product->description }}</p>
        
        <hr>
        
        <h3 class="text-primary">Rp {{ number_format($product->price, 0, ',', '.') }}</h3>
        
        @auth
          <!-- Form Add to Cart dengan quantity -->
          <form action="{{ route('cart.add') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            
            <div class="row g-2 align-items-end">
              <div class="col-auto">
                <label for="quantity" class="form-label">Jumlah</label>
                <input type="number" name="quantity" id="quantity" class="form-control" value="1" min="1" max="100" style="width: 100px;">
              </div>
              <div class="col-auto">
                <button type="submit" class="btn btn-primary btn-lg">🛒 Tambah ke Keranjang</button>
              </div>
            </div>
          </form>
        @else
          <a href="{{ route('login') }}" class="btn btn-primary btn-lg mt-3">Login untuk Membeli</a>
        @endauth
      </div>
    </div>
  </div>
  
  <div class="col-md-4">
    <div class="card">
      <div class="card-body">
        <h5>Informasi Produk</h5>
        <table class="table table-sm">
          <tr>
            <td>Kategori</td>
            <td><strong>{{ $product->category->name }}</strong></td>
          </tr>
          <tr>
            <td>Harga</td>
            @if ($product->discount > 0)
              <p class="text-muted text-decoration-line-through mb-1">
                Rp {{ number_format($product->price, 0, ',', '.') }}
              </p>

              <h3 class="text-success">
                Rp {{ number_format($product->finalPrice(), 0, ',', '.') }}
              </h3>

              <span class="badge bg-danger">
                Diskon {{ $product->discount }}%
              </span>
            @else
              <h3 class="text-primary">
                Rp {{ number_format($product->price, 0, ',', '.') }}
              </h3>
            @endif
          </tr>
          <tr>
            <td>Ditambahkan</td>
            <td>{{ $product->created_at->format('d M Y') }}</td>
          </tr>
        </table>
        
        <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100 mt-3">
          ← Kembali ke Daftar Produk
        </a>
      </div>
    </div>
  </div>
</div>
@endsection