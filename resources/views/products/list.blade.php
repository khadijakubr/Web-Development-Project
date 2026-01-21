@extends('layouts.app')

@section('title', 'Product List')

@php
    $hasQuery = collect(request()->query())
        ->except('page')
        ->filter()
        ->isNotEmpty();

    $isFirstPage = request('page', 1) == 1;
@endphp

@section('content')

@if ($isFirstPage && !$hasQuery)
    <!-- Hero Section -->
    <div class="row align-items-center mb-5">
        <div class="col-md-6">
            <h1 class="display-5 fw-bold">
                Find Your Next Favorite Book
            </h1>
            <p class="text-muted">
                Discover books that inspire, educate, and entertain.
            </p>
        </div>
        <div class="col-md-6 text-center">
            <img
                src="/images/books-hero.png"
                class="img-fluid"
                alt="Books"
            >
        </div>
    </div>
@endif

<!-- Pakai component -->
<x-product-filter 
  :action="route('products')" 
  :categories="$categories" 
/>

@auth
<a href="{{ route('products.create') }}"
  class="btn btn-primary position-fixed bottom-0 end-0 m-4 shadow">
  + Add Product
</a>
@endauth

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
