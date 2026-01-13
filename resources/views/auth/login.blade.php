@extends('layouts.auth')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8 space-y-6">
    <div>
        <h1 class="text-2xl font-light text-gray-900">Welcome back</h1>
        <p class="text-gray-600 text-sm mt-2">Login to continue</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
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
                autofocus
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
                placeholder="Enter your password"
                required
            >
            @error('password')
                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center">
                <input type="checkbox" name="remember" class="w-4 h-4 border border-gray-300 rounded focus:ring-gray-900">
                <span class="ml-2 text-sm text-gray-700">Remember me</span>
            </label>
            <a href="{{ route('password.request') }}" class="text-sm text-gray-600 hover:text-gray-900 transition">Forgot password?</a>
        </div>

        <button 
            type="submit" 
            class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition"
        >
            Sign In
        </button>

        <p class="text-center text-sm text-gray-700">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-gray-900 font-medium hover:underline">Create one</a>
        </p>
    </form>
</div>
@endsection
