@extends('layouts.app')

@section('content')
<div class="auth-card text-center">
    <h4 class="mb-2">Verify Your Email</h4>

    <p class="text-muted mb-4">
        Thanks for signing up! Please verify your email address by clicking
        the link we sent to your inbox.
    </p>

    @if (session('status') === 'verification-link-sent')
        <div class="alert alert-success small">
            A new verification link has been sent to your email.
        </div>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn btn-primary w-100 mb-3">
            Resend Verification Email
        </button>
    </form>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="btn btn-link text-danger small">
            Log out
        </button>
    </form>
</div>
@endsection
