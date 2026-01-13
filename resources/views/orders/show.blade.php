@extends('layouts.app')

@section('title', 'Order Details #' . $order->id)

@section('content')
<div class="order-detail-container">
    <!-- Page Header -->
    <div class="order-detail-header">
        <div>
            <h1 class="page-title">Order Details</h1>
            <p class="page-subtitle">Order #{{ $order->id }} • {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>

    <!-- Main Content Grid -->
    <div class="order-detail-grid">
        <!-- Left Column: Order Items -->
        <div class="order-detail-left">
            <!-- Order Card -->
            <div class="card order-card">
                <div class="card-header order-card-header">
                    <div>
                        <h2 class="card-title">Order Items</h2>
                        <p class="card-subtitle">{{ $order->items->count() }} item(s) in this order</p>
                    </div>
                    <div class="order-status-badge">
                        @if($order->status == 'pending')
                            <span class="status-badge status-pending">Pending Payment</span>
                        @elseif($order->status == 'paid')
                            <span class="status-badge status-paid">Paid</span>
                        @elseif($order->status == 'processing')
                            <span class="status-badge status-processing">Processing</span>
                        @elseif($order->status == 'completed')
                            <span class="status-badge status-completed">Completed</span>
                        @else
                            <span class="status-badge status-cancelled">Cancelled</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <!-- Items Table -->
                    <div class="order-items-table">
                        <table class="table order-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th width="100">Price</th>
                                    <th width="80">Qty</th>
                                    <th width="120" class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <p class="item-name">{{ $item->product->name }}</p>
                                        <small class="item-category">{{ $item->product->category->name }}</small>
                                        @if($order->status == 'completed')
                                            @php
                                                $userReview = \App\Models\Review::where([
                                                    'user_id' => auth()->id(),
                                                    'product_id' => $item->product->id,
                                                    'order_id' => $order->id,
                                                ])->first();
                                            @endphp
                                            @if(!$userReview)
                                                <br>
                                                <a href="{{ route('reviews.create', ['order' => $order->id, 'product' => $item->product->id]) }}" class="btn-write-review btn-sm">
                                                    Write Review
                                                </a>
                                            @else
                                                <br>
                                                <span class="review-posted-badge">✓ Reviewed</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <span class="item-price">
                                            @if($item->product->discount && $item->product->discount > 0)
                                                <small style="color: #999; text-decoration: line-through;">Rp{{ number_format($item->product->price, 2) }}</small><br>
                                                <strong style="color: #ff9800;">Rp{{ number_format($item->product_discounted_price, 2) }}</strong>
                                            @else
                                                Rp{{ number_format($item->product->price, 2) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        <span class="item-quantity">{{ $item->quantity }}</span>
                                    </td>
                                    <td class="text-end">
                                        <strong class="item-subtotal">Rp{{ number_format($item->quantity * $item->product_discounted_price, 2) }}</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Order Summary -->
                    <div class="order-summary">
                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value">Rp {{ number_format($order->total_price, 2) }}</span>
                        </div>

                        <!-- Applied Promo Component -->
                        <x-promo-display :promo="$order->promo" :discountAmount="$order->discount" />

                        <div class="summary-row summary-total">
                            <span class="summary-label">Total Amount</span>
                            <span class="summary-value">Rp {{ number_format($order->final_price ?? $order->total_price - $order->discount, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Order Information & Timeline -->
        <div class="order-detail-right">
            <!-- Shipping Address Card -->
            <div class="card order-info-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-geo-alt"></i> Shipping Address
                    </h3>
                </div>
                <div class="card-body">
                    <p class="order-info-value">{{ $order->shipping_address }}</p>
                </div>
            </div>

            <!-- Payment Information Card -->
            <div class="card order-info-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-credit-card"></i> Payment Information
                    </h3>
                </div>
                <div class="card-body">
                    <div class="payment-method">
                        <label class="info-label">Payment Method</label>
                        <p class="info-value">
                            @if($order->payment_method == 'transfer_bca')
                                Bank Transfer (BCA)
                                <br><small class="text-muted">Account: 1234567890</small>
                            @elseif($order->payment_method == 'transfer_mandiri')
                                Bank Transfer (Mandiri)
                                <br><small class="text-muted">Account: 0987654321</small>
                            @elseif($order->payment_method == 'gopay')
                                GoPay
                                <br><small class="text-muted">Mobile payment</small>
                            @else
                                Cash on Delivery (COD)
                                <br><small class="text-muted">Pay on delivery</small>
                            @endif
                        </p>
                    </div>

                    <!-- Payment Status Alert -->
                    <div class="payment-status-alert">
                        @if($order->status == 'pending')
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-circle"></i>
                                <strong>Awaiting Payment</strong>
                                <p>Please complete your payment to proceed with the order.</p>
                            </div>
                        @elseif($order->status == 'paid')
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle"></i>
                                <strong>Payment Confirmed</strong>
                                <p>Your payment has been received successfully.</p>
                            </div>
                        @elseif($order->status == 'processing')
                            <div class="alert alert-info">
                                <i class="bi bi-hourglass-split"></i>
                                <strong>Processing Order</strong>
                                <p>Your order is being prepared for shipment.</p>
                            </div>
                        @elseif($order->status == 'completed')
                            <div class="alert alert-success">
                                <i class="bi bi-check-all"></i>
                                <strong>Order Completed</strong>
                                <p>Thank you for your purchase!</p>
                            </div>
                        @else
                            <div class="alert alert-danger">
                                <i class="bi bi-x-circle"></i>
                                <strong>Order Cancelled</strong>
                                <p>This order has been cancelled.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Timeline Card -->
            <div class="card order-info-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="bi bi-clock-history"></i> Order Timeline
                    </h3>
                </div>
                <div class="card-body">
                    <div class="order-timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <small class="timeline-date">{{ $order->created_at->format('d M Y, H:i') }}</small>
                                <p class="timeline-text">Order Created</p>
                            </div>
                        </div>

                        @if($order->status != 'pending')
                        <div class="timeline-item">
                            <div class="timeline-marker"></div>
                            <div class="timeline-content">
                                <small class="timeline-date">{{ $order->updated_at->format('d M Y, H:i') }}</small>
                                <p class="timeline-text">
                                    @if($order->status == 'paid')
                                        Payment Confirmed
                                    @elseif($order->status == 'processing')
                                        Order Processing
                                    @elseif($order->status == 'completed')
                                        Order Completed
                                    @else
                                        Order Cancelled
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection