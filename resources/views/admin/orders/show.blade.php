@extends('admin.layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="mb-0"><i class="bi bi-receipt"></i> Order #{{ $order->id }} Details</h2>
    </div>
    <div class="col text-end">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Orders
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Order Information -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-info-circle"></i> Order Information</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="text-muted small">Order ID</label>
                    <p class="mb-0"><strong>#{{ $order->id }}</strong></p>
                </div>
                <hr>
                <div class="mb-3">
                    <label class="text-muted small">Customer Name</label>
                    <p class="mb-0"><strong>{{ $order->user->name }}</strong></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Email</label>
                    <p class="mb-0"><strong>{{ $order->user->email }}</strong></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Phone</label>
                    <p class="mb-0"><strong>{{ $order->user->phone ?? 'N/A' }}</strong></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted small">Address</label>
                    <p class="mb-0"><strong>{{ $order->user->address ?? 'N/A' }}</strong></p>
                </div>
                <hr>
                <div class="mb-3">
                    <label class="text-muted small">Order Date</label>
                    <p class="mb-0"><strong>{{ $order->created_at->format('d M Y H:i') }}</strong></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-arrow-repeat"></i> Update Order Status</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="status" class="form-label">Current Status</label>
                        <select name="status" id="status" class="form-select mb-3">
                            <option value="pending" @selected($order->status === 'pending')>
                                <i class="bi bi-clock"></i> Pending
                            </option>
                            <option value="paid" @selected($order->status === 'paid')>
                                <i class="bi bi-check-circle"></i> Paid
                            </option>
                            <option value="processing" @selected($order->status === 'processing')>
                                <i class="bi bi-gear"></i> Processing
                            </option>
                            <option value="completed" @selected($order->status === 'completed')>
                                <i class="bi bi-check-all"></i> Completed
                            </option>
                            <option value="cancelled" @selected($order->status === 'cancelled')>
                                <i class="bi bi-x-circle"></i> Cancelled
                            </option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save"></i> Update Status
                    </button>
                </form>

                <hr>

                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i>
                    <small>
                        <strong>Current Status:</strong>
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
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Items -->
<div class="card mt-4">
    <div class="card-header bg-light">
        <h5 class="mb-0"><i class="bi bi-box"></i> Order Items</h5>
    </div>
    <div class="card-body">
        @if($order->items->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Product</th>
                            <th width="80" class="text-center">Quantity</th>
                            <th width="120" class="text-end">Unit Price</th>
                            <th width="120" class="text-end">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                <strong>{{ $item->product->name }}</strong>
                                @if($item->product->description)
                                    <br>
                                    <small class="text-muted">{{ Str::limit($item->product->description, 60) }}</small>
                                @endif
                            </td>
                            <td class="text-center">
                                {{ $item->quantity }}
                            </td>
                            <td class="text-end">
                                Rp {{ number_format($item->price, 0, ',', '.') }}
                            </td>
                            <td class="text-end">
                                <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Order Total -->
            <div class="row mt-4">
                <div class="col-md-6 offset-md-6">
                    <div class="card border-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal:</span>
                                <strong>Rp {{ number_format($order->total_price, 0, ',', '.') }}</strong>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between">
                                <h5 class="mb-0">Total Order:</h5>
                                <h5 class="mb-0 text-success">Rp {{ number_format($order->total_price, 0, ',', '.') }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-4">
                <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                <p class="text-muted mt-2">No items in this order</p>
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
