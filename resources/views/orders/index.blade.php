@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="row">
  <div class="col-12">
    <h1 class="mb-4">📦 Pesanan Saya</h1>
  </div>
</div>

@if($orders->isEmpty())
  <!-- Belum Ada Order -->
  <div class="alert alert-info text-center">
    <h4>Anda belum memiliki pesanan</h4>
    <p>Yuk, mulai belanja sekarang!</p>
    <a href="{{ route('products') }}" class="btn btn-primary">Lihat Produk</a>
  </div>
@else
  <!-- List Orders -->
  @foreach($orders as $order)
    <div class="card mb-3">
      <div class="card-body">
        <div class="row align-items-center">
          <!-- Kolom Info Order -->
          <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-start mb-2">
              <div>
                <h5 class="mb-1">Order #{{ $order->id }}</h5>
                <small class="text-muted">{{ $order->created_at->format('d M Y, H:i') }}</small>
              </div>
              <div>
                @if($order->status == 'pending')
                  <span class="badge bg-warning text-dark">Menunggu Pembayaran</span>
                @elseif($order->status == 'processing')
                  <span class="badge bg-info">Sedang Diproses</span>
                @elseif($order->status == 'completed')
                  <span class="badge bg-success">Selesai</span>
                @else
                  <span class="badge bg-danger">Dibatalkan</span>
                @endif
              </div>
            </div>
            
            <hr>
            
            <!-- List Item (Max 3, sisanya "dan X lainnya") -->
            <div class="mb-2">
              @foreach($order->items->take(3) as $item)
                <div class="mb-1">
                  <small>{{ $item->product->name }} <span class="text-muted">({{ $item->quantity }}x)</span></small>
                </div>
              @endforeach
              
              @if($order->items->count() > 3)
                <small class="text-muted">dan {{ $order->items->count() - 3 }} produk lainnya</small>
              @endif
            </div>
            
            <div>
              <strong>Total: </strong>
              <span class="text-primary fw-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
            
            <div class="mt-2">
              <small class="text-muted">
                <strong>Pembayaran:</strong> 
                @if($order->payment_method == 'transfer_bca')
                  Transfer BCA
                @elseif($order->payment_method == 'transfer_mandiri')
                  Transfer Mandiri
                @elseif($order->payment_method == 'gopay')
                  GoPay
                @else
                  COD (Cash on Delivery)
                @endif
              </small>
            </div>
          </div>
          
          <!-- Kolom Tombol -->
          <div class="col-md-4 text-md-end">
            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">Lihat Detail</a>
          </div>
        </div>
      </div>
    </div>
  @endforeach
  
  <!-- Pagination -->
  <div class="mt-4 d-flex justify-content-center">
    {{ $orders->links() }}
  </div>
@endif
@endsection