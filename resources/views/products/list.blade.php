@extends('layouts.app')

@section('title', 'Product List')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h1>Products</h1>
  <a href="{{ route('products.create') }}" class="btn btn-primary">Add new product</a>
</div>

<div class="row row-cols-1 row-cols-md-3 g-3">
  @foreach($products as $product)
    <div class="col">
      <x-product-card 
          :id="$product['id']"
          :name="$product['name']" 
          :description="$product['description']" 
          :price="$product['price']" />
    </div>
  @endforeach
</div>
@endsection
