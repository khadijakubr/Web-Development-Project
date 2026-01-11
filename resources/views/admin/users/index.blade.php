@extends('admin.layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col">
        <h2 class="mb-0"><i class="bi bi-people"></i> Users Management</h2>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-body">
        @if($users->count())
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th width="100">Phone</th>
                            <th width="150">Role</th>
                            <th width="140">Joined At</th>
                            <th width="220">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                        <tr>
                            <td>
                                <span class="badge bg-secondary">{{ $users->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <strong>{{ $user->name }}</strong>
                            </td>
                            <td>
                                <small class="text-muted">{{ $user->email }}</small>
                            </td>
                            <td>
                                <small>{{ $user->phone ?? '—' }}</small>
                            </td>
                            <td>
                                @if($user->id === auth()->id())
                                    <span class="badge bg-primary">
                                        <i class="bi bi-shield-check"></i> {{ ucfirst($user->role) }}
                                    </span>
                                @else
                                    <form
                                        action="{{ route('admin.users.updateRole', $user->id) }}"
                                        method="POST"
                                        class="d-inline"
                                    >
                                        @csrf
                                        @method('PUT')
                                        <div class="input-group input-group-sm">
                                            <select
                                                name="role"
                                                class="form-select form-select-sm"
                                                onchange="this.form.submit()"
                                            >
                                                <option value="user" @selected($user->role === 'user')>
                                                    User
                                                </option>
                                                <option value="admin" @selected($user->role === 'admin')>
                                                    Admin
                                                </option>
                                            </select>
                                        </div>
                                    </form>
                                @endif
                            </td>
                            <td>
                                <small>{{ optional($user->created_at)->format('d M Y') ?? '—' }}</small>
                            </td>
                            <td>
                                @if($user->id !== auth()->id())
                                    <form
                                        action="{{ route('admin.users.destroy', $user->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')"
                                    >
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger" type="submit">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-success">
                                        <i class="bi bi-check-circle"></i> You
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                {{ $users->links('pagination::bootstrap-5') }}
            </nav>
        @else
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">No users found</p>
            </div>
        @endif
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: rgba(52, 152, 219, 0.05);
    }
</style>
@endsection
