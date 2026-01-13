@extends('admin.layouts.app')

@section('content')
<div class="admin-products-container">
    <!-- Page Header -->
    <div class="admin-products-header">
        <div>
            <h1 class="admin-page-title">Edit Product</h1>
            <p class="admin-page-subtitle">Update product information</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-secondary">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>

    <!-- Edit Product Form -->
    <div class="admin-card">
        <div class="admin-card-body">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="product-form">
                @csrf @method('PUT')

                <div class="form-sections">
                    <!-- Left Column: Product Information -->
                    <div class="form-left-column">
                        <!-- Product Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">Product Name *</label>
                            <input 
                                type="text" 
                                class="form-control @error('name') is-invalid @enderror"
                                id="name" 
                                name="name"
                                value="{{ old('name', $product->name) }}"
                                placeholder="Enter product name"
                                required
                            >
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="form-group">
                            <label for="description" class="form-label">Description *</label>
                            <textarea 
                                class="form-control @error('description') is-invalid @enderror"
                                id="description" 
                                name="description"
                                rows="5"
                                placeholder="Enter product description"
                                required
                            >{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label for="category_id" class="form-label">Category *</label>
                            <select 
                                class="form-control @error('category_id') is-invalid @enderror"
                                id="category_id" 
                                name="category_id"
                                required
                            >
                                <option value="">Select a category</option>
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
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Right Column: Image -->
                    <div class="form-right-column">
                        <!-- Current Image -->
                        @if($product->image)
                            <div class="form-group">
                                <label class="form-label">Current Image</label>
                                <div class="current-image-container">
                                    <img 
                                        src="{{ asset('storage/'.$product->image) }}" 
                                        alt="{{ $product->name }}"
                                        class="current-product-image"
                                    >
                                </div>
                            </div>
                        @endif

                        <!-- Image Upload -->
                        <div class="form-group">
                            <label for="image" class="form-label">{{ $product->image ? 'Change Image' : 'Product Image' }}</label>
                            <div class="image-upload-wrapper">
                                <input 
                                    type="file" 
                                    class="form-control @error('image') is-invalid @enderror"
                                    id="image" 
                                    name="image"
                                    accept="image/*"
                                    onchange="previewImage(event)"
                                >
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Image Preview -->
                            <div class="image-preview-section">
                                <div id="imagePreview" class="image-preview-container">
                                    <div class="image-placeholder">
                                        <i class="bi bi-image"></i>
                                        <p>{{ $product->image ? 'Select new image' : 'No image selected' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price and Discount Section -->
                <div class="price-section">
                    <div class="form-group form-group-inline">
                        <label for="price" class="form-label">Price (Rp) *</label>
                        <input 
                            type="number" 
                            class="form-control @error('price') is-invalid @enderror"
                            id="price" 
                            name="price"
                            value="{{ old('price', $product->price) }}"
                            step="1000"
                            min="0"
                            placeholder="0"
                            onchange="calculateFinalPrice()"
                            oninput="calculateFinalPrice()"
                            required
                        >
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group form-group-inline">
                        <label for="discount" class="form-label">Discount (%)</label>
                        <input 
                            type="number" 
                            class="form-control @error('discount') is-invalid @enderror"
                            id="discount" 
                            name="discount"
                            value="{{ old('discount', $product->discount ?? 0) }}"
                            step="0.01"
                            min="0"
                            max="100"
                            placeholder="0"
                            onchange="calculateFinalPrice()"
                            oninput="calculateFinalPrice()"
                        >
                        @error('discount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Final Price Display -->
                <div class="admin-card price-card">
                    <div class="price-card-content">
                        <span class="price-card-label">Final Price:</span>
                        <span class="price-card-value" id="finalPrice">Rp 0</span>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="bi bi-check-lg"></i> Update Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn-admin btn-admin-secondary">
                        <i class="bi bi-x-lg"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('imagePreview');
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
        };
        reader.readAsDataURL(file);
    } else {
        preview.innerHTML = `
            <div class="image-placeholder">
                <i class="bi bi-image"></i>
                <p>{{ $product->image ? 'Select new image' : 'No image selected' }}</p>
            </div>
        `;
    }
}

function calculateFinalPrice() {
    const price = parseFloat(document.getElementById('price').value) || 0;
    const discount = parseFloat(document.getElementById('discount').value) || 0;
    const finalPrice = price - (price * discount / 100);
    
    document.getElementById('finalPrice').innerText = 
        'Rp ' + finalPrice.toLocaleString('id-ID', {maximumFractionDigits: 0});
}

// Calculate on page load if there are old values
document.addEventListener('DOMContentLoaded', function() {
    calculateFinalPrice();
});
</script>
@endsection
