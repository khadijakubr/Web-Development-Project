@extends('admin.layouts.app')

@section('content')
<div class="admin-products-container">
    <!-- Page Header -->
    <div class="admin-products-header">
        <div>
            <h1 class="admin-page-title">Products Management</h1>
            <p class="admin-page-subtitle">Manage and organize your product catalog</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin-primary">
            <i class="bi bi-plus-lg"></i> Add New Product
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

    <!-- Products Table -->
    <div class="admin-card">
        <div class="admin-card-body">
            @if($products->count())
                <div class="products-table-wrapper">
                    <table class="products-admin-table">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
                                <th width="80">Image</th>
                                <th>Product Name</th>
                                <th width="110">Price</th>
                                <th width="100">Category</th>
                                <th width="80">Discount</th>
                                <th width="100">Final Price</th>
                                <th width="140" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <span class="product-id-badge">{{ $product->id }}</span>
                                </td>
                                <td>
                                    @if($product->image)
                                        <img 
                                            src="{{ asset('storage/'.$product->image) }}" 
                                            alt="{{ $product->name }}"
                                            class="product-table-image"
                                        >
                                    @else
                                        <div class="product-image-placeholder">
                                            <i class="bi bi-image"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="product-cell-info">
                                        <p class="product-cell-name">{{ $product->name }}</p>
                                        @if($product->description)
                                            <p class="product-cell-desc">{{ Str::limit($product->description, 50) }}</p>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <span class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </td>
                                <td>
                                    <span class="category-badge">{{ $product->category->name }}</span>
                                </td>
                                <td class="text-center">
                                    @if($product->discount > 0)
                                        <span class="discount-badge">{{ $product->discount }}%</span>
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="final-price">Rp {{ number_format($product->finalPrice(), 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="product-actions">
                                        <a 
                                            href="{{ route('admin.products.edit', $product->id) }}" 
                                            class="btn-admin btn-admin-secondary btn-sm"
                                            title="Edit product"
                                        >
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form 
                                            action="{{ route('admin.products.destroy', $product->id) }}" 
                                            method="POST" 
                                            class="product-delete-form"
                                            onsubmit="return confirm('Are you sure you want to delete this product?')"
                                        >
                                            @csrf @method('DELETE')
                                            <button class="btn-admin btn-admin-danger btn-sm" type="submit" title="Delete product">
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
                @if($products->hasPages())
                    <div class="products-pagination">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>No products found</p>
                    <small>Create your first product to get started</small>
                    <a href="{{ route('admin.products.create') }}" class="btn-admin btn-admin-primary" style="margin-top: 1rem;">
                        <i class="bi bi-plus-lg"></i> Create Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
