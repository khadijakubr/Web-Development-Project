@extends('admin.layouts.app')

@section('content')
<div class="admin-categories-container">
    <!-- Page Header -->
    <div class="admin-page-header">
        <div>
            <h1 class="admin-page-title">Categories Management</h1>
            <p class="admin-page-subtitle">Manage product categories</p>
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

    <div class="admin-categories-layout">
        <!-- Add Category Form Section -->
        <div class="admin-form-section">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Add New Category</h2>
                </div>
                <div class="admin-card-body">
                    <form method="POST" action="{{ route('admin.categories.store') }}" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="name" class="form-label">Category Name <span class="required">*</span></label>
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
                        <button type="submit" class="btn-admin btn-admin-primary w-100">
                            <i class="bi bi-plus-lg"></i> Add Category
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Categories List Section -->
        <div class="admin-list-section">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h2 class="admin-card-title">Categories List</h2>
                    <span class="category-count">{{ $categories->count() }} item(s)</span>
                </div>
                <div class="admin-card-body">
                    @if($categories->count())
                        <div class="categories-list">
                            @foreach($categories as $category)
                            <div class="category-item">
                                <div class="category-info">
                                    <h3 class="category-name">{{ $category->name }}</h3>
                                </div>
                                <form 
                                    method="POST" 
                                    action="{{ route('admin.categories.destroy', $category->id) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this category?')"
                                    class="category-action"
                                >
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn-admin btn-admin-danger btn-sm">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="bi bi-inbox"></i>
                            <p>No categories yet</p>
                            <small>Create your first category to organize products</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
