@extends('layouts.app')

@section('content')
<div class="auth-card">
    <h4 class="mb-1">Welcome back</h4>
    <p class="text-muted mb-4">Login to continue</p>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required autofocus>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="remember">
                <label class="form-check-label">Remember me</label>
            </div>

            <a href="{{ route('password.request') }}" class="small">Forgot password?</a>
        </div>

        <button class="btn btn-primary w-100">Login</button>

        <p class="text-center small mt-3">
            Don’t have an account?
            <a href="{{ route('register') }}">Register</a>
        </p>
    </form>
</div>
@endsection
