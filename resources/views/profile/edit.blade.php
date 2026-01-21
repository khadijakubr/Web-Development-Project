@extends('layouts.app') {{-- pakai layout utama Bootstrap --}}

@section('title', 'Profile')

@section('content')
<div class="container py-5">
    <!-- Header -->
    <div class="mb-4">
        <h2 class="fw-bold text-dark">Profile</h2>
    </div>

    <div class="row g-4">
        <!-- Update Profile Information -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <!-- Update Password -->
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <!-- Delete User -->
        <div class="col-12">
            <div class="card shadow-sm border-danger">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
