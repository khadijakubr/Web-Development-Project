@extends('admin.layouts.app')

@section('content')
<div class="admin-promo-container">
    <!-- Page Header -->
    <div class="admin-promo-header">
        <div>
            <h1 class="admin-page-title">Edit Promo Code</h1>
            <p class="admin-page-subtitle">Update promotional discount code: <strong>{{ $promo->code }}</strong></p>
        </div>
        <a href="{{ route('admin.promos.index') }}" class="btn-admin btn-admin-secondary">
            <i class="bi bi-arrow-left"></i> Back to Promos
        </a>
    </div>

    <!-- Form Card -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2 class="admin-card-title">Promo Code Details</h2>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.promos.update', $promo) }}" method="POST" class="promo-form">
                @csrf
                @method('PUT')

                <!-- Promo Code -->
                <div class="form-group">
                    <label for="code" class="form-label">Promo Code *</label>
                    <input type="text" id="code" name="code" value="{{ old('code', $promo->code) }}" 
                        class="form-control @error('code') is-invalid @enderror" required>
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Discount Type & Value Row -->
                <div class="form-row">
                    <!-- Discount Type -->
                    <div class="form-group">
                        <label for="discount_type" class="form-label">Discount Type *</label>
                        <select id="discount_type" name="discount_type" class="form-control @error('discount_type') is-invalid @enderror" required>
                            <option value="percentage" {{ old('discount_type', $promo->discount_type) === 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                            <option value="fixed" {{ old('discount_type', $promo->discount_type) === 'fixed' ? 'selected' : '' }}>Fixed Amount ($)</option>
                        </select>
                        @error('discount_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Discount Value -->
                    <div class="form-group">
                        <label for="discount_value" class="form-label">Discount Value *</label>
                        <input type="number" id="discount_value" name="discount_value" value="{{ old('discount_value', $promo->discount_value) }}" 
                            class="form-control @error('discount_value') is-invalid @enderror" step="0.01" required>
                        @error('discount_value')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Max Uses & Expiry Date Row -->
                <div class="form-row">
                    <!-- Max Uses -->
                    <div class="form-group">
                        <label for="max_uses" class="form-label">Maximum Uses</label>
                        <input type="number" id="max_uses" name="max_uses" value="{{ old('max_uses', $promo->max_uses) }}" 
                            class="form-control @error('max_uses') is-invalid @enderror">
                        <small class="form-text">Current uses: <strong>{{ $promo->current_uses }}</strong></small>
                        @error('max_uses')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Expiry Date -->
                    <div class="form-group">
                        <label for="expiry_date" class="form-label">Expiry Date</label>
                        <input type="date" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $promo->expiry_date?->format('Y-m-d')) }}" 
                            class="form-control @error('expiry_date') is-invalid @enderror">
                        @error('expiry_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Description -->
                <div class="form-group">
                    <label for="description" class="form-label">Description</label>
                    <textarea id="description" name="description" rows="3" 
                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $promo->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="form-checkbox">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                        {{ old('is_active', $promo->is_active) ? 'checked' : '' }} class="form-check-input">
                    <label for="is_active" class="form-check-label">Active</label>
                </div>

                <!-- Action Buttons -->
                <div class="form-actions">
                    <button type="submit" class="btn-admin btn-admin-primary">
                        <i class="bi bi-arrow-repeat"></i> Update Promo Code
                    </button>
                    <a href="{{ route('admin.promos.index') }}" class="btn-admin btn-admin-secondary">
                        <i class="bi bi-x-circle"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection