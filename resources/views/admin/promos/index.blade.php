@extends('admin.layouts.app')

@section('content')
<div class="admin-promo-container">
    <!-- Page Header -->
    <div class="admin-promo-header">
        <div>
            <h1 class="admin-page-title">Promo Code Management</h1>
            <p class="admin-page-subtitle">Create and manage promotional discount codes</p>
        </div>
        <a href="{{ route('admin.promos.create') }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-plus-circle"></i> Create Promo Code
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

    <!-- Promos Table Card -->
    <div class="admin-card">
        <div class="admin-card-body">
            @if($promos->count())
                <div class="promos-table-wrapper">
                    <table class="promos-admin-table">
                        <thead>
                            <tr>
                                <th width="100">Code</th>
                                <th width="100">Type</th>
                                <th width="100">Value</th>
                                <th width="120">Uses</th>
                                <th width="130">Expires</th>
                                <th width="90">Status</th>
                                <th width="100" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($promos as $promo)
                            <tr>
                                <td>
                                    <span class="promo-code-badge">{{ $promo->code }}</span>
                                </td>
                                <td>
                                    <span class="discount-type-badge">
                                        {{ $promo->discount_type === 'percentage' ? '%' : 'Rp' }}
                                    </span>
                                </td>
                                <td>
                                    <strong class="promo-value">
                                        @if($promo->discount_type === 'percentage')
                                            {{ $promo->discount_value }}%
                                        @else
                                            Rp{{ number_format($promo->discount_value, 2) }}
                                        @endif
                                    </strong>
                                </td>
                                <td>
                                    <small class="promo-uses">
                                        {{ $promo->current_uses }}
                                        @if($promo->max_uses)
                                            / {{ $promo->max_uses }}
                                        @else
                                            / ∞
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <small class="promo-expiry">
                                        @if($promo->expiry_date)
                                            {{ $promo->expiry_date->format('M d, Y') }}
                                        @else
                                            No limit
                                        @endif
                                    </small>
                                </td>
                                <td>
                                    <span class="status-badge {{ $promo->is_active ? 'status-active' : 'status-inactive' }}">
                                        {{ $promo->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="promo-actions">
                                        <a href="{{ route('admin.promos.edit', $promo) }}" class="btn-admin btn-admin-secondary btn-sm" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST" class="promo-delete-form" onsubmit="return confirm('Are you sure you want to delete this promo code?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-admin btn-admin-danger btn-sm" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($promos->hasPages())
                    <div class="promos-pagination">
                        {{ $promos->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-tag"></i>
                    <p>No promo codes found</p>
                    <small>Create your first promo code to get started</small>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection