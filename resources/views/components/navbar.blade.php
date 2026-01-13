<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">

        <!-- LEFT: Logo -->
        <a class="navbar-brand fw-semibold" href="{{ route('products') }}">
            Bookverse
        </a>

        <!-- TOGGLER (Hamburger) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- RIGHT -->
        <div class="collapse navbar-collapse" id="mainNavbar">
            <!-- Desktop Menu -->
            <div class="ms-auto d-flex align-items-center gap-2 d-none d-lg-flex">

                <!-- SEARCH (Desktop Only) -->
                <form class="d-flex" method="GET" action="{{ route('products') }}">
                    <input
                        class="form-control"
                        type="search"
                        name="q"
                        placeholder="I want to read..."
                        value="{{ request('q') }}"
                        style="width: 220px;"
                    >
                </form>

                <button class="btn btn-outline-secondary">
                    <i class="bi bi-search"></i>
                </button>

                <!-- CART (Desktop) -->
                @auth
                    @if(Auth::user()->role === 'user')
                        <a class="btn btn-outline-secondary position-relative" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart"></i>
                        </a>
                    @endif
                @endauth

                <!-- DARK MODE TOGGLE (Desktop) -->
                <button id="dark-mode-toggle" class="btn btn-outline-secondary dark-mode-toggle-btn" title="Toggle Dark Mode">
                    <span class="toggle-icon">🌙</span>
                </button>

                <!-- AUTH (Desktop) -->
                @auth
                    <div class="dropdown">
                        <a class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">

                            @if(Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        Admin Dashboard
                                    </a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="{{ route('dashboard') }}">
                                        Dashboard
                                    </a>
                                </li>

                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
                                        My Orders
                                    </a>
                                </li>
                            @endif

                            <li><hr class="dropdown-divider"></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="btn btn-primary btn-sm" href="{{ route('login') }}">
                        Login
                    </a>
                @endauth

            </div>

            <!-- Mobile Menu (Hamburger Dropdown) -->
            <div class="ms-auto d-flex d-lg-none flex-column w-100 mt-3">
                
                <!-- Mobile Search -->
                <form class="d-flex mb-3" method="GET" action="{{ route('products') }}">
                    <input
                        class="form-control form-control-sm"
                        type="search"
                        name="q"
                        placeholder="Search books..."
                        value="{{ request('q') }}"
                    >
                    <button class="btn btn-outline-secondary btn-sm ms-2" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>

                <!-- Mobile Dark Mode Toggle -->
                <button id="dark-mode-toggle-mobile" class="btn btn-outline-secondary mb-2 text-start dark-mode-toggle-btn" title="Toggle Dark Mode">
                    <span class="toggle-icon">🌙</span> <span class="toggle-text">Dark Mode</span>
                </button>

                <!-- Mobile Cart Link (User Only) -->
                @auth
                    @if(Auth::user()->role === 'user')
                        <a class="btn btn-outline-secondary mb-2 text-start" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart"></i> Cart
                        </a>
                    @endif
                @endauth

                <!-- Mobile Auth Menu -->
                @auth
                    @if(Auth::user()->role === 'user')
                        <!-- User Menu -->
                        <a class="btn btn-outline-secondary mb-2 text-start" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>

                        <a class="btn btn-outline-secondary mb-2 text-start" href="{{ route('orders.index') }}">
                            <i class="bi bi-receipt"></i> My Orders
                        </a>
                    @else
                        <!-- Admin Menu -->
                        <a class="btn btn-outline-secondary mb-2 text-start" href="{{ route('admin.dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    @endif

                    <!-- Profile (for all authenticated users) -->
                    <a class="btn btn-outline-secondary mb-2 text-start" href="{{ route('profile.edit') }}">
                        <i class="bi bi-person-circle"></i> Profile
                    </a>

                    <!-- Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="w-100">
                        @csrf
                        <button class="btn btn-outline-danger w-100 text-start">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                @else
                    <!-- Not Authenticated -->
                    <a class="btn btn-primary w-100" href="{{ route('login') }}">
                        Login
                    </a>
                @endauth

            </div>
        </div>

    </div>
</nav>
