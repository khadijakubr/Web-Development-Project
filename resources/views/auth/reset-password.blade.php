@extends('layouts.auth')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8 space-y-6">
    <div>
        <h1 class="text-2xl font-light text-gray-900">Reset Password</h1>
        <p class="text-gray-600 text-sm mt-2">Create a new password for your account</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-1.5">Email Address</label>
            <input
                type="email"
                name="email"
                value="{{ old('email', $request->email) }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                placeholder="Enter your email"
                required
            >
            @error('email')
                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-1.5">Password</label>
            <input
                type="password"
                name="password"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                placeholder="Create a strong password"
                required
            >
            @error('password')
                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-1.5">Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                placeholder="Confirm your password"
                required
            >
            @error('password_confirmation')
                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <button 
            type="submit" 
            class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition"
        >
            Reset Password
        </button>
    </form>
</div>
@endsection
