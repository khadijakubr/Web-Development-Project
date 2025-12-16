@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="mb-4">🛒 Keranjang Belanja</h1>
  </div>
</div>

@if($cartItems->isEmpty())
  <!-- Cart Kosong -->
  <div class="alert alert-info text-center">
    <h4>Keranjang belanja Anda kosong</h4>
    <p>Yuk, mulai belanja sekarang!</p>
    <a href="{{ route('products') }}" class="btn btn-primary">Lihat Produk</a>
  </div>
@else
  <!-- Cart Ada Isinya -->
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($cartItems as $item)
                <tr>
                  <!-- Kolom Produk -->
                  <td>
                    <div class="d-flex align-items-center">
                      <div>
                        <h6 class="mb-0">{{ $item->product->name }}</h6>
                        <small class="text-muted">{{ $item->product->category->name }}</small>
                      </div>
                    </div>
                  </td>
                  
                  <!-- Kolom Harga -->
                  <td>
                    <span class="fw-bold">Rp {{ number_format($item->product->price, 0, ',', '.') }}</span>
                  </td>
                  
                  <!-- Kolom Quantity -->
                  <td>
                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-inline">
                      @csrf
                      <div class="input-group" style="width: 130px;">
                        <input type="number" name="quantity" class="form-control form-control-sm" value="{{ $item->quantity }}" min="1" max="100">
                        <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                      </div>
                    </form>
                  </td>
                  
                  <!-- Kolom Subtotal -->
                  <td>
                    <span class="fw-bold text-primary">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                  </td>
                  
                  <!-- Kolom Aksi -->
                  <td>
                    <form action="{{ route('cart.remove', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">🗑️ Hapus</button>
                    </form>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    
    <!-- Sidebar Summary -->
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Ringkasan Belanja</h5>
          <hr>
          
          <div class="d-flex justify-content-between mb-2">
            <span>Total Item:</span>
            <span class="fw-bold">{{ $cartItems->sum('quantity') }}</span>
          </div>
          
          <div class="d-flex justify-content-between mb-3">
            <span>Total Harga:</span>
            <span class="fw-bold text-primary fs-5">Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>
          
          <hr>
          
          <a href="{{ route('checkout.index') }}" class="btn btn-success w-100 btn-lg">
            Lanjut ke Checkout
          </a>
          
          <a href="{{ route('products') }}" class="btn btn-outline-secondary w-100 mt-2">
            Lanjut Belanja
          </a>
        </div>
      </div>
    </div>
  </div>
@endif
@endsection