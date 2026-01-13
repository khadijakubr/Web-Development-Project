@extends('layouts.auth')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8 space-y-6">
    <div>
        <h1 class="text-2xl font-light text-gray-900">Verify Email</h1>
        <p class="text-gray-600 text-sm mt-2">Please verify your email address</p>
    </div>

    @if (session('resent'))
        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-700 text-sm">A fresh verification link has been sent to your email address.</p>
        </div>
    @endif

    <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg">
        <p class="text-gray-700 text-sm">Before proceeding, please check your email for a verification link.</p>
        <p class="text-gray-600 text-xs mt-2">If you did not receive the email, we will gladly send you another.</p>
    </div>

    <form method="POST" action="{{ route('verification.send') }}" class="space-y-4">
        @csrf

        <button 
            type="submit" 
            class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition"
        >
            Resend Verification Email
        </button>

        <form method="POST" action="{{ route('logout') }}" class="text-center mt-4">
            @csrf
            <button 
                type="submit"
                class="text-gray-600 hover:text-gray-900 text-sm font-medium transition"
            >
                Sign out
            </button>
        </form>
    </form>
</div>
@endsection
