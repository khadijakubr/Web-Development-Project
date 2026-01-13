@extends('admin.layouts.app')

@section('content')
<div class="admin-orders-container">
    <!-- Page Header -->
    <div class="admin-orders-header">
        <div>
            <h1 class="admin-page-title">Orders Management</h1>
            <p class="admin-page-subtitle">Track and manage all customer orders</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            <i class="bi bi-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="admin-alert-close" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="admin-card">
        <div class="admin-card-body">
            @if($orders->count())
                <div class="orders-table-wrapper">
                    <table class="orders-admin-table">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
                                <th>Customer Name</th>
                                <th>Email Address</th>
                                <th width="120">Total Price</th>
                                <th width="110">Status</th>
                                <th width="130">Order Date</th>
                                <th width="80" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $order)
                            <tr>
                                <td>
                                    <span class="order-id-badge">#{{ $order->id }}</span>
                                </td>
                                <td>
                                    <p class="order-customer-name">{{ $order->user->name }}</p>
                                </td>
                                <td>
                                    <p class="order-customer-email">{{ $order->user->email }}</p>
                                </td>
                                <td>
                                    <span class="order-total-price">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusClass = 'status-' . $order->status;
                                    @endphp
                                    <span class="order-status-badge {{ $statusClass }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="order-date">{{ $order->created_at->format('d M Y H:i') }}</small>
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

                <!-- Pagination -->
                @if($orders->hasPages())
                    <div class="orders-pagination">
                        {{ $orders->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>No orders found</p>
                    <small>Orders will appear here when customers place them</small>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
