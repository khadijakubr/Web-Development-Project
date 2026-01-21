@extends('layouts.app')

@section('content')
<div class="auth-card">
    <h4 class="mb-1">Forgot Password</h4>
    <p class="text-muted mb-4">
        Enter your email and we’ll send a reset link
    </p>

    @if (session('status'))
        <div class="alert alert-success small">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input
                type="email"
                name="email"
                class="form-control"
                required
            >
        </div>

        <button class="btn btn-primary w-100">
            Send Reset Link
        </button>

        <p class="text-center small mt-3">
            <a href="{{ route('login') }}">Back to login</a>
        </p>
    </form>
</div>
@endsection
