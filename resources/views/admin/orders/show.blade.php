@extends('admin.layouts.app')

@section('content')
<div class="admin-order-detail-container">
    <!-- Page Header -->
    <div class="admin-order-detail-header">
        <div>
            <h1 class="admin-page-title">Order #{{ $order->id }}</h1>
            <p class="admin-page-subtitle">View and manage order details</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn-admin btn-admin-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            <i class="bi bi-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="admin-alert-close" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    @endif

    <!-- Two Column Layout -->
    <div class="order-detail-grid">
        <!-- Left Column: Order Information -->
        <div class="order-detail-left">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Order Information</h3>
                </div>
                <div class="admin-card-body">
                    <div class="order-info-section">
                        <label class="order-info-label">Order ID</label>
                        <p class="order-info-value">#{{ $order->id }}</p>
                    </div>

                    <div class="order-info-section">
                        <label class="order-info-label">Customer Name</label>
                        <p class="order-info-value">{{ $order->user->name }}</p>
                    </div>

                    <div class="order-info-section">
                        <label class="order-info-label">Email Address</label>
                        <p class="order-info-value">{{ $order->user->email }}</p>
                    </div>

                    <div class="order-info-section">
                        <label class="order-info-label">Phone Number</label>
                        <p class="order-info-value">{{ $order->user->phone ?? 'Not provided' }}</p>
                    </div>

                    <div class="order-info-section">
                        <label class="order-info-label">Shipping Address</label>
                        <p class="order-info-value">{{ $order->user->address ?? 'Not provided' }}</p>
                    </div>

                    <div class="order-info-section">
                        <label class="order-info-label">Order Date & Time</label>
                        <p class="order-info-value">{{ $order->created_at->format('d M Y \\a\\t H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Status Update -->
        <div class="order-detail-right">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Update Order Status</h3>
                </div>
                <div class="admin-card-body">
                    <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="status-update-form">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="status" class="form-label">Select New Status</label>
                            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                                <option value="pending" @selected($order->status === 'pending')>Pending</option>
                                <option value="paid" @selected($order->status === 'paid')>Paid</option>
                                <option value="processing" @selected($order->status === 'processing')>Processing</option>
                                <option value="completed" @selected($order->status === 'completed')>Completed</option>
                                <option value="cancelled" @selected($order->status === 'cancelled')>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-admin btn-admin-primary w-100">
                            <i class="bi bi-arrow-repeat"></i> Update Status
                        </button>
                    </form>

                    <div class="status-info-box">
                        <div class="status-info-header">
                            <i class="bi bi-info-circle"></i>
                            <span>Current Status</span>
                        </div>
                        @php
                            $statusClass = 'status-' . $order->status;
                        @endphp
                        <div class="status-info-content">
                            <span class="order-status-badge-large {{ $statusClass }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Items Section -->
    <div class="admin-card" style="margin-top: 2rem;">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Order Items ({{ $order->items->count() }})</h3>
        </div>
        <div class="admin-card-body">
            @if($order->items->count())
                <div class="order-items-table-wrapper">
                    <table class="order-items-table">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th width="100" class="text-center">Quantity</th>
                                <th width="140" class="text-right">Unit Price</th>
                                <th width="140" class="text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="order-item-info">
                                        <p class="order-item-name">{{ $item->product->name }}</p>
                                        @if($item->product->description)
                                            <p class="order-item-desc">{{ Str::limit($item->product->description, 60) }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <span class="quantity-badge">{{ $item->quantity }}</span>
                                </td>
                                <td class="text-right">
                                    <span class="price-text">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-right">
                                    <span class="subtotal-text">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Order Total Summary -->
                <div class="order-total-summary">
                    <div class="total-row">
                        <span class="total-label">Order Total:</span>
                        <span class="total-value">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>No items in this order</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
