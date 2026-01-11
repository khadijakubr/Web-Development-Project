<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    {{-- Admin Custom Styles --}}
    @vite(['resources/css/fonts.css', 'resources/css/admin.css'])
</head>
<body>

<div class="admin-wrapper">

    {{-- Sidebar --}}
    <aside class="admin-sidebar">
        <div class="sidebar-brand">
            <i class="bi bi-speedometer2"></i>
            <h5>Admin Dashboard</h5>
        </div>

        <ul class="nav-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="@if(Route::currentRouteName() === 'admin.dashboard') active @endif"><i class="bi bi-house-door"></i> Dashboard</a></li>
            <li><a href="{{ route('admin.products.index') }}" class="@if(str_contains(Route::currentRouteName(), 'admin.products')) active @endif"><i class="bi bi-box"></i> Products</a></li>
            <li><a href="{{ route('admin.categories.index') }}" class="@if(str_contains(Route::currentRouteName(), 'admin.categories')) active @endif"><i class="bi bi-tag"></i> Categories</a></li>
            <li><a href="{{ route('admin.orders.index') }}" class="@if(str_contains(Route::currentRouteName(), 'admin.orders')) active @endif"><i class="bi bi-bag-check"></i> Orders</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="@if(str_contains(Route::currentRouteName(), 'admin.users')) active @endif"><i class="bi bi-people"></i> Users</a></li>
            <li><a href="{{ route('products') }}" target="_blank" class="view-store-link"><i class="bi bi-shop"></i> View Store</a></li>
        </ul>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="btn btn-logout btn-sm" type="submit"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </div>
    </aside>

    {{-- Content --}}
    <div class="admin-content">
        <main class="admin-main">
            {{-- ALERTS - Only display here, inside content --}}
            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show alert-container mb-4" role="alert">
                    <strong><i class="bi bi-exclamation-circle"></i> Validation Errors!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show alert-container mb-4" role="alert">
                    <strong><i class="bi bi-exclamation-circle"></i> Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@vite(['resources/js/app.js'])
</body>
</html>