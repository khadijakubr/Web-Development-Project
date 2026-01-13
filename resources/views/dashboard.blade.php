@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-container">
    <!-- Header Section -->
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="dashboard-subtitle">Here's what's happening with your account</p>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <!-- Total Orders -->
        <div class="stat-card">
            <div class="stat-icon">❒</div>
            <div class="stat-content">
                <p class="stat-label">Total Orders</p>
                <p class="stat-value">{{ Auth::user()->orders->count() }}</p>
            </div>
        </div>

        <!-- Total Spent -->
        <div class="stat-card">
            <div class="stat-icon">💲</div>
            <div class="stat-content">
                <p class="stat-label">Total Spent</p>
                <p class="stat-value">Rp {{ number_format(Auth::user()->orders->sum('final_price') ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Active Cart Items -->
        <div class="stat-card">
            <div class="stat-icon">🛒</div>
            <div class="stat-content">
                <p class="stat-label">Cart Items</p>
                <p class="stat-value">{{ Auth::user()->cartItems->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <h2 class="section-title">Quick Actions</h2>
        <div class="actions-grid">
            <a href="{{ route('products') }}" class="action-btn">
                <span class="action-icon">𖠩</span>
                <span class="action-text">Continue Shopping</span>
            </a>
            <a href="{{ route('cart.index') }}" class="action-btn">
                <span class="action-icon">🛒</span>
                <span class="action-text">View Cart</span>
            </a>
            <a href="{{ route('orders.index') }}" class="action-btn">
                <span class="action-icon">✎</span>
                <span class="action-text">My Orders</span>
            </a>
            <a href="{{ route('profile.edit') }}" class="action-btn">
                <span class="action-icon">ጸ</span>
                <span class="action-text">Edit Profile</span>
            </a>
        </div>
    </div>

    <!-- Recent Orders Section -->
    @if(Auth::user()->orders->count() > 0)
    <div class="recent-orders">
        <h2 class="section-title">Recent Orders</h2>
        <div class="orders-table-wrapper">
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(Auth::user()->orders->take(5) as $order)
                    <tr>
                        <td class="order-id">#{{ $order->id }}</td>
                        <td class="order-date">{{ $order->created_at->format('d M Y') }}</td>
                        <td class="order-total">Rp {{ number_format($order->final_price, 0, ',', '.') }}</td>
                        <td class="order-status">
                            <span class="status-badge">{{ ucfirst($order->status ?? 'pending') }}</span>
                        </td>
                        <td>
                            <a href="{{ route('orders.show', $order->id) }}" class="view-btn">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="empty-state">
        <p class="empty-icon">⚠︎</p>
        <p class="empty-text">No orders yet</p>
        <p class="empty-subtext">Start shopping to create your first order</p>
        <br>
        <a href="{{ route('products') }}" class="btn btn-primary">Start Shopping</a>
    </div>
    @endif
</div>
@endsection
