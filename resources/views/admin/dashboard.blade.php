@extends('admin.layouts.app')

@section('content')
<h1 class="mb-4"><i class="bi bi-speedometer2"></i> Dashboard</h1>

<!-- Stats Cards -->
<div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-2">Total Products</h6>
                        <h3 class="text-primary mb-0">{{ $totalProducts }}</h3>
                    </div>
                    <div class="stat-icon text-primary">
                        <i class="bi bi-box"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-2">Total Users</h6>
                        <h3 class="text-success mb-0">{{ $totalUsers }}</h3>
                    </div>
                    <div class="stat-icon text-success">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-2">Total Orders</h6>
                        <h3 class="text-info mb-0">{{ $totalOrders }}</h3>
                    </div>
                    <div class="stat-icon text-info">
                        <i class="bi bi-bag-check"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted mb-2">Quick Links</h6>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-plus"></i> Add Product
                        </a>
                    </div>
                    <div class="stat-icon text-warning">
                        <i class="bi bi-lightning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Latest Orders -->
<div class="card border-0 shadow-sm">
    <div class="card-header bg-light border-bottom">
        <h5 class="mb-0"><i class="bi bi-clock-history"></i> Latest Orders</h5>
    </div>
    <div class="card-body">
        @if($latestOrders->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th width="100">Total</th>
                            <th width="120">Status</th>
                            <th width="100">Date</th>
                            <th width="80" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestOrders as $order)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">#{{ $order->id }}</span>
                            </td>
                            <td>
                                <strong>{{ $order->user->name }}</strong>
                            </td>
                            <td>
                                <small class="text-muted">{{ $order->user->email }}</small>
                            </td>
                            <td>
                                <span class="fw-bold text-success">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'paid' => 'info',
                                        'processing' => 'primary',
                                        'completed' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                    $statusColor = $statusColors[$order->status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $statusColor }} text-uppercase">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td>
                                <small>{{ $order->created_at->format('d M Y') }}</small>
                            </td>
                            <td class="text-center">
                                <a 
                                    href="{{ route('admin.orders.show', $order->id) }}" 
                                    class="btn btn-sm btn-outline-primary"
                                    title="View"
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
            <div class="text-center py-4">
                <i class="bi bi-inbox text-muted empty-state-icon"></i>
                <p class="text-muted mt-2">No orders yet</p>
            </div>
        @endif
    </div>
</div>
@endsection