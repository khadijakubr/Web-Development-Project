@extends('layouts.app') {{-- pakai layout utama Bootstrap --}}

@section('title', 'Dashboard')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark">Dashboard</h2>
    </div>

    <!-- Card -->
    <div class="card shadow-sm">
        <div class="card-body">
            <p class="mb-0">You're logged in!</p>
        </div>
    </div>
</div>
@endsection
