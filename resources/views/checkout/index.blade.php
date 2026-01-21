@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="mb-4">💳 Checkout</h1>
  </div>
</div>

<form action="{{ route('checkout.process') }}" method="POST">
  @csrf
  
  <div class="row">
    <!-- Form Pengiriman & Pembayaran -->
    <div class="col-lg-8">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Alamat Pengiriman</h5>
          <hr>
          
          <div class="mb-3">
            <label for="shipping_address" class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
            <textarea 
              name="shipping_address" 
              id="shipping_address" 
              class="form-control @error('shipping_address') is-invalid @enderror" 
              rows="4" 
              placeholder="Contoh: Jl. Merdeka No. 10, RT 02/RW 05, Kelurahan Sukamaju, Kecamatan Tanah Abang, Jakarta Pusat, DKI Jakarta 10160"
              required>{{ old('shipping_address', $user->address) }}</textarea>
            @error('shipping_address')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <small class="text-muted">Pastikan alamat lengkap dan jelas agar paket sampai dengan aman.</small>
          </div>
        </div>
      </div>
      
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">💰 Metode Pembayaran</h5>
          <hr>
          
          <div class="mb-3">
            <label class="form-label">Pilih Metode Pembayaran <span class="text-danger">*</span></label>
            
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="payment_method" id="payment_bca" value="transfer_bca" {{ old('payment_method') == 'transfer_bca' ? 'checked' : '' }} required>
              <label class="form-check-label" for="payment_bca">
                <strong>Transfer Bank BCA</strong>
                <br>
                <small class="text-muted">No. Rek: 1234567890 a.n. Toko Buku</small>
              </label>
            </div>
            
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="payment_method" id="payment_mandiri" value="transfer_mandiri" {{ old('payment_method') == 'transfer_mandiri' ? 'checked' : '' }}>
              <label class="form-check-label" for="payment_mandiri">
                <strong>Transfer Bank Mandiri</strong>
                <br>
                <small class="text-muted">No. Rek: 0987654321 a.n. Toko Buku</small>
              </label>
            </div>
            
            <div class="form-check mb-2">
              <input class="form-check-input" type="radio" name="payment_method" id="payment_gopay" value="gopay" {{ old('payment_method') == 'gopay' ? 'checked' : '' }}>
              <label class="form-check-label" for="payment_gopay">
                <strong>GoPay</strong>
                <br>
                <small class="text-muted">Pembayaran via aplikasi Gojek</small>
              </label>
            </div>
            
            <div class="form-check">
              <input class="form-check-input" type="radio" name="payment_method" id="payment_cod" value="cod" {{ old('payment_method') == 'cod' ? 'checked' : '' }}>
              <label class="form-check-label" for="payment_cod">
                <strong>COD (Cash on Delivery)</strong>
                <br>
                <small class="text-muted">Bayar di tempat saat barang tiba</small>
              </label>
            </div>
            
            @error('payment_method')
              <div class="text-danger mt-2">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
    </div>
    
    <!-- Sidebar Summary Order -->
    <div class="col-lg-4">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">📋 Ringkasan Pesanan</h5>
          <hr>
          
          <!-- List Produk -->
          <div class="mb-3">
            @foreach($cartItems as $item)
              <div class="d-flex justify-content-between mb-2">
                <div>
                  <small>{{ $item->product->name }}</small>
                  <br>
                  <small class="text-muted">{{ $item->quantity }} x Rp {{ number_format($item->product->price, 0, ',', '.') }}</small>
                </div>
                <div>
                  <small class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</small>
                </div>
              </div>
            @endforeach
          </div>
          
          <hr>
          
          <!-- Total -->
          <div class="d-flex justify-content-between mb-3">
            <span class="fw-bold">Total Pembayaran:</span>
            <span class="fw-bold text-primary fs-4">Rp {{ number_format($total, 0, ',', '.') }}</span>
          </div>
          
          <hr>
          
          <!-- Tombol Submit -->
          <button type="submit" class="btn btn-success w-100 btn-lg">
            ✅ Konfirmasi Pesanan
          </button>
          
          <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary w-100 mt-2">
            ← Kembali ke Keranjang
          </a>
          
          <div class="alert alert-warning mt-3 mb-0">
            <small>
              <strong>Catatan:</strong> Setelah konfirmasi, pesanan akan diproses dan keranjang akan dikosongkan.
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection