@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="orders-container">
  <!-- Page Header -->
  <div class="orders-header">
    <h1 class="orders-title">My Orders</h1>
    <p class="orders-subtitle">Track and manage your purchases</p>
  </div>

  @if($orders->isEmpty())
    <!-- No Orders State -->
    <div class="orders-empty">
      <p class="empty-icon">📦</p>
      <p class="empty-text">No orders yet</p>
      <p class="empty-subtext">Start shopping to create your first order</p>
      <a href="{{ route('products') }}" class="btn btn-primary">Start Shopping</a>
    </div>
  @else
    <!-- Orders List -->
    <div class="orders-list">
      @foreach($orders as $order)
        <div class="order-card">
          <!-- Order Header -->
          <div class="order-card-header">
            <div class="order-info">
              <h3 class="order-number">Order #{{ $order->id }}</h3>
              <p class="order-date">{{ $order->created_at->format('d M Y, H:i') }}</p>
            </div>
            <div class="order-status">
              @if($order->status == 'pending')
                <span class="status-badge status-pending">Pending</span>
              @elseif($order->status == 'paid')
                <span class="status-badge status-paid">Paid</span>
              @elseif($order->status == 'processing')
                <span class="status-badge status-processing">Processing</span>
              @elseif($order->status == 'completed')
                <span class="status-badge status-completed">Delivered</span>
              @else
                <span class="status-badge status-cancelled">Cancelled</span>
              @endif
            </div>
          </div>

          <!-- Order Items -->
          <div class="order-card-body">
            <div class="order-items">
              <h4 class="order-items-title">Items</h4>
              
              @foreach($order->items->take(3) as $item)
                <div class="order-item">
                  <span class="item-name">{{ $item->product->name }}</span>
                  <span class="item-qty">{{ $item->quantity }}x</span>
                </div>
              @endforeach

              @if($order->items->count() > 3)
                <div class="order-item">
                  <span class="item-more text-muted">and {{ $order->items->count() - 3 }} more item(s)</span>
                </div>
              @endif
            </div>

            <!-- Order Summary -->
            <div class="order-summary">
              <div class="summary-row">
                <span class="summary-label">Total Price</span>
                <span class="summary-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
              </div>

              @if($order->promo)
                <div class="summary-row" style="color: #28a745; font-weight: bold;">
                  <span class="summary-label">Discount ({{ $order->promo->code }})</span>
                  <span class="summary-value">-Rp {{ number_format($order->discount, 0, ',', '.') }}</span>
                </div>

                <div class="summary-row" style="border-top: 1px solid #ddd; padding-top: 8px; margin-top: 8px;">
                  <span class="summary-label"><strong>Final Price</strong></span>
                  <span class="summary-value"><strong>Rp {{ number_format($order->final_price ?? ($order->total_price - $order->discount), 0, ',', '.') }}</strong></span>
                </div>
              @endif

              <div class="summary-row">
                <span class="summary-label">Payment Method</span>
                <span class="summary-value">
                  @if($order->payment_method == 'transfer_bca')
                    Bank Transfer
                  @elseif($order->payment_method == 'transfer_mandiri')
                    Bank Transfer
                  @elseif($order->payment_method == 'gopay')
                    E-Wallet
                  @else
                    Cash on Delivery
                  @endif
                </span>
              </div>
            </div>
          </div>

          <!-- Order Footer -->
          <div class="order-card-footer">
            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">View Details</a>
          </div>
        </div>
      @endforeach
    </div>

    <!-- Pagination -->
    @if ($orders->count() > 0)
      <div class="orders-pagination">
        {{ $orders->links() }}
      </div>
    @endif
  @endif
</div>
@endsection