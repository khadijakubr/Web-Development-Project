<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - {{ config('app.name') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5.3.3 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    {{-- Admin Custom Styles --}}
    @vite(['resources/css/admin.css', 'resources/css/fonts.css', 'resources/css/app.css', 'resources/js/admin-products.js'])
</head>
<body class="admin-body">

<div class="admin-wrapper">

    {{-- Sidebar Navigation --}}
    <aside class="admin-sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-brand">
            <i class="bi bi-speedometer2"></i>
            <h5>Admin Panel</h5>
        </div>

        <!-- Navigation Menu -->
        <nav class="sidebar-nav">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link @if(Route::currentRouteName() === 'admin.dashboard') active @endif">
                        <i class="bi bi-house-door"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.products.index') }}" class="nav-link @if(str_contains(Route::currentRouteName(), 'admin.products')) active @endif">
                        <i class="bi bi-box"></i>
                        <span>Products</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link @if(str_contains(Route::currentRouteName(), 'admin.categories')) active @endif">
                        <i class="bi bi-tag"></i>
                        <span>Categories</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.promos.index') }}" class="nav-link @if(str_contains(Route::currentRouteName(), 'admin.promos')) active @endif">
                        <i class="bi bi-ticket-perforated"></i>
                        <span>Promo Codes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.orders.index') }}" class="nav-link @if(str_contains(Route::currentRouteName(), 'admin.orders')) active @endif">
                        <i class="bi bi-bag-check"></i>
                        <span>Orders</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link @if(str_contains(Route::currentRouteName(), 'admin.users')) active @endif">
                        <i class="bi bi-people"></i>
                        <span>Users</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products') }}" target="_blank" class="nav-link view-store-link">
                        <i class="bi bi-shop"></i>
                        <span>View Store</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Logout Section -->
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST" class="w-100">
                @csrf
                <button class="btn-logout" type="submit">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content Area --}}
    <div class="admin-content">
        <main class="admin-main">
            {{-- Validation Errors --}}
            @if($errors->any())
                <div class="admin-alert admin-alert-danger" role="alert">
                    <div class="alert-header">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>Validation Errors</strong>
                        <button type="button" class="admin-alert-close" onclick="this.parentElement.parentElement.style.display='none';">×</button>
                    </div>
                    <div class="alert-body">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            {{-- Session Error --}}
            @if(session('error'))
                <div class="admin-alert admin-alert-danger" role="alert">
                    <div class="alert-header">
                        <i class="bi bi-exclamation-circle"></i>
                        <strong>Error</strong>
                        <button type="button" class="admin-alert-close" onclick="this.parentElement.parentElement.style.display='none';">×</button>
                    </div>
                    <div class="alert-body">
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            {{-- Page Content --}}
            @yield('content')
        </main>
    </div>

</div>

{{-- Bootstrap 5.3.3 JS --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>