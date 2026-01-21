@extends('layouts.app')

@section('content')
<div class="auth-card">
    <h4 class="mb-1">Create Account</h4>
    <p class="text-muted mb-4">Join Bookverse today</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Phone</label>
            <input
                type="text"
                name="phone"
                class="form-control"
                value="{{ old('phone') }}"
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea
                name="address"
                rows="3"
                class="form-control"
            >{{ old('address') }}</textarea>
        </div>

        {{-- Password TIDAK pakai old() --}}
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                required
            >
        </div>

        <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="form-control"
                required
            >
        </div>

        <button class="btn btn-primary w-100">
            Register
        </button>

        <p class="text-center small mt-3">
            Already have an account?
            <a href="{{ route('login') }}">Login</a>
        </p>
    </form>
</div>
@endsection
