@extends('admin.layouts.app')

@section('content')
<div class="admin-users-container">
    <!-- Page Header -->
    <div class="admin-users-header">
        <div>
            <h1 class="admin-page-title">Users Management</h1>
            <p class="admin-page-subtitle">View and manage all system users</p>
        </div>
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

    <!-- Users Table -->
    <div class="admin-card">
        <div class="admin-card-body">
            @if($users->count())
                <div class="users-table-wrapper">
                    <table class="users-admin-table">
                        <thead>
                            <tr>
                                <th width="50">ID</th>
                                <th>Full Name</th>
                                <th>Email Address</th>
                                <th width="120">Phone</th>
                                <th width="110">Role</th>
                                <th width="120">Member Since</th>
                                <th width="100" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $index => $user)
                            <tr>
                                <td>
                                    <span class="user-id-badge">{{ $users->firstItem() + $index }}</span>
                                </td>
                                <td>
                                    <p class="user-name">{{ $user->name }}</p>
                                </td>
                                <td>
                                    <p class="user-email">{{ $user->email }}</p>
                                </td>
                                <td>
                                    <small class="user-phone">{{ $user->phone ?? '—' }}</small>
                                </td>
                                <td class="text-center">
                                    @if($user->id === auth()->id())
                                        <span class="role-badge role-badge-current">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    @else
                                        <form
                                            action="{{ route('admin.users.updateRole', $user->id) }}"
                                            method="POST"
                                            class="role-update-form"
                                        >
                                            @csrf
                                            @method('PUT')
                                            <select
                                                name="role"
                                                class="role-select"
                                                onchange="this.form.submit()"
                                            >
                                                <option value="user" @selected($user->role === 'user')>User</option>
                                                <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                            </select>
                                        </form>
                                    @endif
                                </td>
                                <td>
                                    <small class="user-date">{{ optional($user->created_at)->format('d M Y') ?? '—' }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="user-actions">
                                        <a 
                                            href="{{ route('admin.users.show', $user->id) }}" 
                                            class="btn-admin btn-admin-secondary btn-sm"
                                            title="View user details"
                                        >
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form
                                                action="{{ route('admin.users.destroy', $user->id) }}"
                                                method="POST"
                                                class="user-delete-form"
                                                onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn-admin btn-admin-danger btn-sm" type="submit" title="Delete user">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="role-badge role-badge-you">You</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($users->hasPages())
                    <div class="users-pagination">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>No users found</p>
                    <small>Users will appear here when they register</small>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection