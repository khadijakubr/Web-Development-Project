<!-- @extends('layouts.app')

@section('title', $product ? 'Edit Product' : 'Add Product')

@section('content')
<h1>{{ $product ? 'Edit Product' : 'Add Product' }}</h1>

<form action="{{ $action }}" method="POST" enctype="multipart/form-data">
  @csrf

  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $product->name ?? '') }}" required>
    @error('name') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" class="form-control">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
  <label for="category_id" class="form-label">Category</label>
  <select id="category_id" name="category_id" class="form-control" required>
    <option value="">-- Pilih Kategori --</option>
    @foreach($categories as $category)
      <option value="{{ $category->id }}" 
        {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>
        {{ $category->name }}
      </option>
    @endforeach
  </select>
  @error('category_id') <div class="text-danger">{{ $message }}</div> @enderror
</div>

  <div class="mb-3">
    <label for="price" class="form-label">Price</label>
    <input id="price" name="price" type="number" class="form-control" value="{{ old('price', $product->price ?? '') }}" required>
    @error('price') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <div class="mb-3">
    <label for="image" class="form-label">Product Image</label>
    <input id="image" name="image" type="file" class="form-control">

    @if($product && $product->image)
      <img src="{{ asset('storage/' . $product->image) }}"
          class="mt-2"
          style="max-height:150px;">
    @endif

    @error('image') <div class="text-danger">{{ $message }}</div> @enderror
  </div>

  <button type="submit" class="btn btn-success">Save</button>
  <a href="{{ route('products') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection -->
