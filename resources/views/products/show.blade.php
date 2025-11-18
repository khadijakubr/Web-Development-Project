@extends('layouts.app')

@section('title', $product['name'])

@section('content')
<h1>{{ $product['name'] }}</h1>
<p>{{ $product['description'] }}</p>
<p class="fw-bold">Price: ${{ $product['price'] }}</p>

<a href="{{ route('products.edit', ['id' => $product['id']]) }}" class="btn btn-outline-secondary">Edit</a>
<a href="{{ route('products') }}" class="btn btn-secondary">Back to list</a>
@endsection
