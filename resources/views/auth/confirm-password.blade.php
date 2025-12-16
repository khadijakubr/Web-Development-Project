@extends('layouts.app')

@section('content')
<div class="auth-card">
    <h4 class="mb-1">Confirm Password</h4>
    <p class="text-muted mb-4">
        This is a secure area. Please confirm your password.
    </p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-4">
            <label class="form-label">Password</label>
            <input
                type="password"
                name="password"
                class="form-control"
                required
                autocomplete="current-password"
            >
        </div>

        <button class="btn btn-primary w-100">
            Confirm
        </button>
    </form>
</div>
@endsection
