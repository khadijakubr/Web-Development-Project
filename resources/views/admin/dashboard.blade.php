<!-- filepath: /Users/khadijakubr/Herd/AFL1-Webdev/resources/views/admin/dashboard.blade.php -->
@extends('admin.layouts.app')

@section('content')
<div class="admin-dashboard-container">
    <!-- Page Header -->
    <div class="admin-dashboard-header">
        <h1 class="admin-dashboard-title">Dashboard</h1>
        <p class="admin-dashboard-subtitle">Welcome to your admin panel</p>
    </div>

    <!-- Stats Grid -->
    <div class="admin-stats-grid">
        <!-- Total Products -->
        <div class="admin-stat-card">
            <div class="stat-card-content">
                <p class="stat-card-label">Total Products</p>
                <p class="stat-card-value">{{ $totalProducts }}</p>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-box"></i>
            </div>
        </div>

        <!-- Total Users -->
        <div class="admin-stat-card">
            <div class="stat-card-content">
                <p class="stat-card-label">Total Users</p>
                <p class="stat-card-value">{{ $totalUsers }}</p>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-people"></i>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="admin-stat-card">
            <div class="stat-card-content">
                <p class="stat-card-label">Total Orders</p>
                <p class="stat-card-value">{{ $totalOrders }}</p>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-bag-check"></i>
            </div>
        </div>

        <!-- Quick Action -->
        <div class="admin-stat-card admin-stat-card-action">
            <div class="stat-card-content">
                <p class="stat-card-label">Quick Action</p>
                <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin-primary btn-sm">
                    <i class="bi bi-plus-lg"></i> Add Product
                </a>
            </div>
            <div class="stat-card-icon">
                <i class="bi bi-lightning"></i>
            </div>
        </div>
    </div>

    <!-- Latest Orders Section -->
    <div class="admin-latest-orders">
        <div class="admin-card">
            <div class="admin-card-header">
                <h2 class="admin-card-title">Latest Orders</h2>
                <span class="order-count">{{ $latestOrders->count() }} order(s)</span>
            </div>
            <div class="admin-card-body">
                @if($latestOrders->count())
                    <div class="orders-table-wrapper">
                        <table class="orders-admin-table">
                            <thead>
                                <tr>
                                    <th width="60">Order ID</th>
                                    <th>Customer</th>
                                    <th>Email</th>
                                    <th width="110">Total</th>
                                    <th width="120">Status</th>
                                    <th width="100">Date</th>
                                    <th width="80" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($latestOrders as $order)
                                <tr>
                                    <td>
                                        <span class="order-badge">#{{ $order->id }}</span>
                                    </td>
                                    <td>
                                        <strong class="customer-name">{{ $order->user->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="customer-email">{{ $order->user->email }}</span>
                                    </td>
                                    <td>
                                        <span class="order-total">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = 'status-' . strtolower($order->status);
                                        @endphp
                                        <span class="order-status-badge {{ $statusClass }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="order-date">{{ $order->created_at->format('d M Y') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <a 
                                            href="{{ route('admin.orders.show', $order->id) }}" 
                                            class="btn-admin btn-admin-secondary btn-sm"
                                            title="View order details"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>No orders yet</p>
                        <small>Orders will appear here when customers place them</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection