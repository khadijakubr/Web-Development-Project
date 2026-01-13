@extends('layouts.auth')

@section('content')
<div class="bg-white rounded-lg shadow-lg p-8 space-y-6">
    <div>
        <h1 class="text-2xl font-light text-gray-900">Confirm Password</h1>
        <p class="text-gray-600 text-sm mt-2">Please confirm your password before continuing</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-4">
        @csrf

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

        <button 
            type="submit" 
            class="w-full bg-gray-900 text-white py-2.5 rounded-lg font-medium hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:ring-offset-2 transition"
        >
            Confirm Password
        </button>
    </form>
</div>
@endsection
