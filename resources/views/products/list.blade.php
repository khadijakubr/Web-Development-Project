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
    <div class="row align-items-center justify-content-evenly mb-5">
        <div class="col-md-6">
            <h1 class="display-5 fw-bold">
                Discover Your Next Favorite Book
            </h1>
            <p class="text-muted">
                Find books that inspire, educate, and entertain.
            </p>
        </div>
        <div class="col-md-5 text-center">
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

<div class="product-grid">
  @foreach($products as $product)
    <div class="col">
      <x-product-card 
          :id="$product->id"
          :name="$product->name" 
          :description="$product->description" 
          :price="$product->price"
          :image="$product->image"
          :discount="$product->discount ?? 0" />
    </div>
  @endforeach
</div>

<div class="mt-4 d-flex justify-content-center">
  {{ $products->links() }}
</div>
@endsection
