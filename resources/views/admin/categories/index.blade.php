@extends('admin.layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="mb-0"><i class="bi bi-tag"></i> Categories Management</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="row">
    <div class="col-lg-6">
        <!-- Add Category Form -->
        <div class="card mb-4">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Add New Category</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.categories.store') }}" novalidate>
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name *</label>
                        <input 
                            type="text"
                            id="name"
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter category name"
                            value="{{ old('name') }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-check-circle"></i> Add Category
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-6">
        <!-- Categories List -->
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0"><i class="bi bi-list-ul"></i> Categories List</h5>
            </div>
            <div class="card-body">
                @if($categories->count())
                    <div class="list-group">
                        @foreach($categories as $category)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">{{ $category->name }}</h6>
                            </div>
                            <form 
                                method="POST" 
                                action="{{ route('admin.categories.destroy', $category->id) }}"
                                onsubmit="return confirm('Are you sure you want to delete this category?')"
                            >
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mt-2">No categories yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
