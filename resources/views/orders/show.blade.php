@extends('layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<div class="row">
  <div class="col-12 mb-4">
    <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">← Kembali ke Daftar Pesanan</a>
  </div>
</div>

<div class="row">
  <!-- Info Order -->
  <div class="col-lg-8">
    <div class="card mb-3">
      <div class="card-body">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <div>
            <h3>Order #{{ $order->id }}</h3>
            <p class="text-muted mb-0">{{ $order->created_at->format('d M Y, H:i') }}</p>
          </div>
          <div>
            @if($order->status == 'pending')
              <span class="badge bg-warning text-dark fs-6">Menunggu Pembayaran</span>
            @elseif($order->status == 'processing')
              <span class="badge bg-info fs-6">Sedang Diproses</span>
            @elseif($order->status == 'completed')
              <span class="badge bg-success fs-6">Selesai</span>
            @else
              <span class="badge bg-danger fs-6">Dibatalkan</span>
            @endif
          </div>
        </div>
        
        <hr>
        
        <!-- List Item Order -->
        <h5 class="mb-3">📦 Item Pesanan</h5>
        <table class="table">
          <thead>
            <tr>
              <th>Produk</th>
              <th>Harga</th>
              <th>Jumlah</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody>
            @foreach($order->items as $item)
              <tr>
                <td>
                  <strong>{{ $item->product->name }}</strong>
                  <br>
                  <small class="text-muted">{{ $item->product->category->name }}</small>
                </td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                <td>{{ $item->quantity }}</td>
                <td class="fw-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
              </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
              <td colspan="3" class="text-end"><strong>Total Pembayaran:</strong></td>
              <td class="fw-bold text-primary fs-5">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  
  <!-- Sidebar Info Pengiriman & Pembayaran -->
  <div class="col-lg-4">
    <!--Alamat Pengiriman -->
        <div class="card mb-3">
            <div class="card-body">
            <h5 class="card-title">📍 Alamat Pengiriman</h5>
            <hr>
            <p class="mb-0">{{ $order->shipping_address }}</p>
        </div>
    </div>
    <!-- Info Pembayaran -->
<div class="card mb-3">
  <div class="card-body">
    <h5 class="card-title">💰 Informasi Pembayaran</h5>
    <hr>
    <div class="mb-2">
      <strong>Metode Pembayaran:</strong>
      <br>
      @if($order->payment_method == 'transfer_bca')
        Transfer Bank BCA
        <br>
        <small class="text-muted">No. Rek: 1234567890 a.n. Toko Buku</small>
      @elseif($order->payment_method == 'transfer_mandiri')
        Transfer Bank Mandiri
        <br>
        <small class="text-muted">No. Rek: 0987654321 a.n. Toko Buku</small>
      @elseif($order->payment_method == 'gopay')
        GoPay
        <br>
        <small class="text-muted">Scan QR Code di aplikasi Gojek</small>
      @else
        COD (Cash on Delivery)
        <br>
        <small class="text-muted">Bayar di tempat saat barang tiba</small>
      @endif
    </div>
    
    @if($order->status == 'pending')
      <div class="alert alert-warning mt-3 mb-0">
        <small><strong>⚠️ Menunggu Pembayaran</strong></small>
        <br>
        <small>Silakan lakukan pembayaran sesuai metode yang dipilih.</small>
      </div>
    @elseif($order->status == 'processing')
      <div class="alert alert-info mt-3 mb-0">
        <small><strong>✅ Pembayaran Dikonfirmasi</strong></small>
        <br>
        <small>Pesanan Anda sedang dikemas dan akan segera dikirim.</small>
      </div>
    @elseif($order->status == 'completed')
      <div class="alert alert-success mt-3 mb-0">
        <small><strong>🎉 Pesanan Selesai</strong></small>
        <br>
        <small>Terima kasih telah berbelanja!</small>
      </div>
    @endif
  </div>
</div>

<!-- Timeline Status (Opsional) -->
<div class="card">
  <div class="card-body">
    <h5 class="card-title">📋 Timeline</h5>
    <hr>
    <div class="timeline">
      <div class="mb-3">
        <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
        <br>
        <strong>Pesanan Dibuat</strong>
      </div>
      
      @if($order->status != 'pending')
        <div class="mb-3">
          <small class="text-muted">{{ $order->updated_at->format('d M Y, H:i') }}</small>
          <br>
          <strong>Status Diupdate</strong>
          <br>
          <small class="text-muted">
            @if($order->status == 'processing')
              Pesanan sedang diproses
            @elseif($order->status == 'completed')
              Pesanan selesai
            @else
              Pesanan dibatalkan
            @endif
          </small>
        </div>
      @endif
    </div>
  </div>
</div>
  </div>
</div>
@endsection