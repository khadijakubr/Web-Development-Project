@extends('layouts.auth')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8 space-y-6">
    <div>
        <h1 class="text-2xl font-light text-gray-900">Forgot Password</h1>
        <p class="text-gray-600 text-sm mt-2">Enter your email and we'll send you a reset link</p>
    </div>

    @if (session('status'))
        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
            <p class="text-green-700 text-sm">{{ session('status') }}</p>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-1.5">Email Address</label>
            <input
                type="email"
                name="email"
                value="{{ old('email') }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                placeholder="Enter your email"
                required
            >
            @error('email')
                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <button 
            type="submit" 
            class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition"
        >
            Send Reset Link
        </button>

        <p class="text-center text-sm">
            <a href="{{ route('login') }}" class="text-gray-900 font-medium hover:underline">Back to login</a>
        </p>
    </form>
</div>
@endsection
