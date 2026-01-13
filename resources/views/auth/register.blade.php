@extends('layouts.auth')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8 space-y-6">
    <div>
        <h1 class="text-2xl font-light text-gray-900">Create Account</h1>
        <p class="text-gray-600 text-sm mt-2">Join us today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-1.5">Full Name</label>
            <input
                type="text"
                name="name"
                value="{{ old('name') }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                placeholder="Enter your name"
                required
            >
            @error('name')
                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

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

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-1.5">Phone (Optional)</label>
            <input
                type="text"
                name="phone"
                value="{{ old('phone') }}"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                placeholder="Enter your phone number"
            >
            @error('phone')
                <p class="text-red-600 text-xs mt-1.5">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-900 mb-1.5">Address (Optional)</label>
            <textarea
                name="address"
                rows="3"
                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition"
                placeholder="Enter your address"
            >{{ old('address') }}</textarea>
            @error('address')
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
        </div>

        <button 
            type="submit" 
            class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition"
        >
            Create Account
        </button>

        <p class="text-center text-sm text-gray-700">
            Already have an account?
            <a href="{{ route('login') }}" class="text-gray-900 font-medium hover:underline">Sign in</a>
        </p>
    </form>
</div>
@endsection
