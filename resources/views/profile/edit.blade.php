@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="profile-container">
    <!-- Header -->
    <div class="profile-header">
        <div>
            <h1 class="profile-title">Account Settings</h1>
            <p class="profile-subtitle">Manage your account information and preferences</p>
        </div>
    </div>

    <div class="profile-content">
        <!-- Update Profile Information -->
        <div class="profile-section">
            <div class="section-header">
                <h2 class="section-title">Profile Information</h2>
                <p class="section-description">Update your name, email, and other account details</p>
            </div>
            <div class="section-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="profile-section">
            <div class="section-header">
                <h2 class="section-title">Change Password</h2>
                <p class="section-description">Keep your account secure with a strong password</p>
            </div>
            <div class="section-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete User -->
        <div class="profile-section profile-section-danger">
            <div class="section-header">
                <h2 class="section-title">Delete Account</h2>
                <p class="section-description">Permanently remove your account and all associated data</p>
            </div>
            <div class="section-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
