@extends('admin.layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="mb-0"><i class="bi bi-pencil-square"></i> Edit Product</h2>
    </div>
    <div class="col text-end">
        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body p-4">
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data" novalidate>
            @csrf @method('PUT')

            <div class="row">
                <div class="col-md-8">
                    <!-- Product Name -->
                    <div class="mb-4">
                        <label for="name" class="form-label">Product Name *</label>
                        <input 
                            type="text"
                            id="name"
                            name="name" 
                            class="form-control @error('name') is-invalid @enderror"
                            placeholder="Enter product name"
                            value="{{ old('name', $product->name) }}"
                            required
                        >
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="description" class="form-label">Description</label>
                        <textarea 
                            id="description"
                            name="description" 
                            class="form-control @error('description') is-invalid @enderror"
                            placeholder="Enter product description"
                            rows="5"
                        >{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label">Category *</label>
                        <select 
                            id="category_id"
                            name="category_id" 
                            class="form-select @error('category_id') is-invalid @enderror"
                            required
                        >
                            <option value="">-- Select Category --</option>
                            @foreach($categories as $category)
                                <option 
                                    value="{{ $category->id }}"
                                    @selected(old('category_id', $product->category_id) == $category->id)
                                >
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Current Image -->
                    @if($product->image)
                        <div class="mb-4">
                            <label class="form-label">Current Image</label>
                            <div class="border rounded p-2">
                                <img 
                                    src="{{ asset('storage/'.$product->image) }}" 
                                    class="img-fluid rounded"
                                    alt="{{ $product->name }}"
                                >
                            </div>
                        </div>
                    @endif

                    <!-- Image Upload -->
                    <div class="mb-4">
                        <label for="image" class="form-label">Change Image</label>
                        <div id="imagePreview" class="mb-3">
                            <div class="image-preview-placeholder">
                                <i class="bi bi-image text-muted"></i>
                                <p class="text-muted mt-2">Select new image</p>
                            </div>
                        </div>
                        <input 
                            type="file" 
                            id="image"
                            name="image" 
                            class="form-control @error('image') is-invalid @enderror"
                            accept="image/*"
                            onchange="previewImage(event)"
                        >
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle"></i> Supported formats: JPG, JPEG, PNG (Max 2MB)
                        </small>
                        @error('image')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Price and Discount Row -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="price" class="form-label">Price (Rp) *</label>
                        <input 
                            type="number" 
                            id="price"
                            name="price" 
                            class="form-control @error('price') is-invalid @enderror"
                            placeholder="0"
                            value="{{ old('price', $product->price) }}"
                            step="1000"
                            min="0"
                            required
                            onchange="calculateDiscount()"
                            oninput="calculateDiscount()"
                        >
                        @error('price')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="mb-4">
                        <label for="discount" class="form-label">Discount (%)</label>
                        <div class="input-group">
                            <input 
                                type="number" 
                                id="discount"
                                name="discount" 
                                class="form-control @error('discount') is-invalid @enderror"
                                placeholder="0"
                                value="{{ old('discount', $product->discount ?? 0) }}"
                                min="0"
                                max="100"
                                onchange="calculateDiscount()"
                                oninput="calculateDiscount()"
                            >
                            <span class="input-group-text">%</span>
                        </div>
                        @error('discount')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Final Price Display -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-border-success mb-4">
                        <div class="card-body">
                            <h6 class="card-title text-muted">Final Price</h6>
                            <h3 class="text-success" id="finalPrice">Rp 0</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bi bi-check-circle"></i> Update Product
                </button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-lg">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
    @vite(['resources/js/admin-products.js'])
@endpush
