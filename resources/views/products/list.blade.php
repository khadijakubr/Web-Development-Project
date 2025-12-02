@extends('layouts.app')

@section('title', 'Product List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Books List</h1>
  <a href="{{ route('products.create') }}" class="btn btn-primary">Add new product</a>
</div>

<!-- Pakai component -->
<x-product-filter 
  :action="route('products.index')" 
  :categories="$categories" 
/>

<div class="row row-cols-1 row-cols-md-3 g-3">
  @foreach($products as $product)
    <div class="col">
      <x-product-card 
          :id="$product->id"
          :name="$product->name" 
          :description="$product->description" 
          :price="$product->price" />
    </div>
  @endforeach
</div>

<div class="mt-4 d-flex justify-content-center">
  {{ $products->links() }}
</div>
@endsection
