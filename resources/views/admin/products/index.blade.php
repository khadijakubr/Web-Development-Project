@extends('admin.layouts.app')

@section('content')
<div class="row mb-4 align-items-center">
    <div class="col">
        <h2 class="mb-0"><i class="bi bi-box"></i> Products Management</h2>
    </div>
    <div class="col text-end">
        <a href="{{ route('admin.products.create') }}" class="btn btn-success btn-lg">
            <i class="bi bi-plus-circle"></i> Add New Product
        </a>
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
        @if($products->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th width="80">Image</th>
                            <th>Name</th>
                            <th width="120">Price</th>
                            <th width="100">Category</th>
                            <th width="80" class="text-center">Discount</th>
                            <th width="120" class="text-center">Final Price</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">{{ $product->id }}</span>
                            </td>
                            <td>
                                @if($product->image)
                                    <img 
                                        src="{{ asset('storage/'.$product->image) }}" 
                                        alt="{{ $product->name }}"
                                        class="product-image"
                                    >
                                @else
                                    <div class="product-image-placeholder">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $product->name }}</strong>
                                @if($product->description)
                                    <br>
                                    <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                <span class="badge bg-info">{{ $product->category->name }}</span>
                            </td>
                            <td class="text-center">
                                @if($product->discount > 0)
                                    <span class="badge bg-warning">{{ $product->discount }}%</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <span class="text-success fw-bold">
                                    Rp {{ number_format($product->finalPrice(), 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a 
                                        href="{{ route('admin.products.edit', $product->id) }}" 
                                        class="btn btn-sm btn-outline-warning"
                                        title="Edit"
                                    >
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form 
                                        action="{{ route('admin.products.destroy', $product->id) }}" 
                                        method="POST" 
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this product?')"
                                    >
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger" type="submit" title="Delete">
                                            <i class="bi bi-trash"></i> Delete
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
            <nav aria-label="Page navigation" class="mt-4">
                {{ $products->links('pagination::bootstrap-5') }}
            </nav>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox empty-state-icon"></i>
                <p class="text-muted mt-3">No products found. <a href="{{ route('admin.products.create') }}">Create the first product</a></p>
            </div>
        @endif
    </div>
</div>
@endsection
