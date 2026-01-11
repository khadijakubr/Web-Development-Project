@extends('admin.layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="mb-0"><i class="bi bi-bag-check"></i> Orders Management</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($orders->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="60">#</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th width="120">Total</th>
                            <th width="120">Status</th>
                            <th width="100">Date</th>
                            <th width="100" class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
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
                                <small>{{ $order->created_at->format('d M Y H:i') }}</small>
                            </td>
                            <td class="text-center">
                                <a 
                                    href="{{ route('admin.orders.show', $order->id) }}" 
                                    class="btn btn-sm btn-outline-primary"
                                    title="View Details"
                                >
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                {{ $orders->links('pagination::bootstrap-5') }}
            </nav>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">No orders found</p>
            </div>
        @endif
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }
</style>
@endsection
