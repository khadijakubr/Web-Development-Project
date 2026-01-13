@extends('admin.layouts.app')

@section('content')
<div class="admin-user-detail-container">
    <!-- Page Header -->
    <div class="admin-user-detail-header">
        <div>
            <h1 class="admin-page-title">User Details</h1>
            <p class="admin-page-subtitle">View and manage user information</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn-admin btn-admin-secondary">
            <i class="bi bi-arrow-left"></i> Back to Users
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="admin-alert admin-alert-success">
            <i class="bi bi-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="admin-alert-close" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    @endif

    <!-- Error Message -->
    @if(session('error'))
        <div class="admin-alert admin-alert-danger">
            <i class="bi bi-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="admin-alert-close" onclick="this.parentElement.style.display='none';">×</button>
        </div>
    @endif

    <!-- Two Column Layout -->
    <div class="user-detail-grid">
        <!-- Left Column: User Information -->
        <div class="user-detail-left">
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">User Information</h3>
                </div>
                <div class="admin-card-body">
                    <!-- User Avatar Section -->
                    <div class="user-avatar-section">
                        <div class="user-avatar">
                            <i class="bi bi-person-circle"></i>
                        </div>
                        <div class="user-basic-info">
                            <p class="user-detail-name">{{ $user->name }}</p>
                            <p class="user-detail-id">ID: #{{ $user->id }}</p>
                        </div>
                    </div>

                    <div class="user-info-divider"></div>

                    <!-- Full Name -->
                    <div class="user-info-section">
                        <label class="user-info-label">Full Name</label>
                        <p class="user-info-value">{{ $user->name }}</p>
                    </div>

                    <!-- Email Address -->
                    <div class="user-info-section">
                        <label class="user-info-label">Email Address</label>
                        <p class="user-info-value">{{ $user->email }}</p>
                    </div>

                    <!-- Phone Number -->
                    <div class="user-info-section">
                        <label class="user-info-label">Phone Number</label>
                        <p class="user-info-value">{{ $user->phone ?? 'Not provided' }}</p>
                    </div>

                    <!-- Shipping Address -->
                    <div class="user-info-section">
                        <label class="user-info-label">Shipping Address</label>
                        <p class="user-info-value">{{ $user->address ?? 'Not provided' }}</p>
                    </div>

                    <!-- Account Created -->
                    <div class="user-info-section">
                        <label class="user-info-label">Account Created</label>
                        <p class="user-info-value">{{ $user->created_at->format('d M Y \a\t H:i') }}</p>
                    </div>

                    <!-- Last Updated -->
                    <div class="user-info-section">
                        <label class="user-info-label">Last Updated</label>
                        <p class="user-info-value">{{ $user->updated_at->format('d M Y \a\t H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Role & Actions -->
        <div class="user-detail-right">
            <!-- Role Management -->
            @if($user->id !== auth()->id())
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Change User Role</h3>
                </div>
                <div class="admin-card-body">
                    <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="role-change-form">
                        @csrf
                        @method('PUT')
                        
                        <div class="form-group">
                            <label for="role" class="form-label">User Role</label>
                            <select name="role" id="role" class="form-control @error('role') is-invalid @enderror">
                                <option value="user" @selected($user->role === 'user')>User</option>
                                <option value="admin" @selected($user->role === 'admin')>Admin</option>
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn-admin btn-admin-primary w-100">
                            <i class="bi bi-arrow-repeat"></i> Update Role
                        </button>
                    </form>

                    <div class="role-info-box">
                        <div class="role-info-header">
                            <i class="bi bi-info-circle"></i>
                            <span>Current Role</span>
                        </div>
                        <div class="role-info-content">
                            <span class="role-badge-large">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @else
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3 class="admin-card-title">Your Account</h3>
                </div>
                <div class="admin-card-body">
                    <div class="self-account-message">
                        <i class="bi bi-shield-check"></i>
                        <p>This is your account. You cannot change your own role.</p>
                    </div>

                    <div class="role-info-box">
                        <div class="role-info-header">
                            <i class="bi bi-info-circle"></i>
                            <span>Your Role</span>
                        </div>
                        <div class="role-info-content">
                            <span class="role-badge-large role-badge-current">
                                {{ ucfirst($user->role) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Danger Zone - Delete User -->
            @if($user->id !== auth()->id())
            <div class="admin-card card-danger">
                <div class="admin-card-header header-danger">
                    <h3 class="admin-card-title">Delete User</h3>
                </div>
                <div class="admin-card-body">
                    <p class="danger-zone-text">
                        Once you delete this user, there is no going back. Please be certain.
                    </p>

                    <form
                        action="{{ route('admin.users.destroy', $user->id) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to permanently delete this user? This action cannot be undone.')"
                    >
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin btn-admin-danger w-100">
                            <i class="bi bi-trash"></i> Delete User
                        </button>
                    </form>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
