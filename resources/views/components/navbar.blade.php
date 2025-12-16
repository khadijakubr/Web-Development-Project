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
            <div class="ms-auto d-flex align-items-center gap-2">

                <!-- SEARCH -->
                <form class="d-flex d-none d-lg-block" method="GET" action="{{ route('products') }}">
                    <input
                        class="form-control"
                        type="search"
                        name="q"
                        placeholder="I want to read..."
                        value="{{ request('q') }}"
                        style="width: 220px;"
                    >
                </form>

                <button class="btn btn-outline-secondary d-none d-lg-block">
                    <i class="bi bi-search"></i>
                </button>

                <!-- CART -->
                <a class="btn btn-outline-secondary position-relative" href="{{ route('cart.index') }}">
                    <i class="bi bi-cart"></i>
                </a>

                <!-- AUTH -->
                @auth
                    <div class="dropdown">
                        <a class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">

                            <!-- Edit Profile -->
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                    Edit Profile
                                </a>
                            </li>

                            <!-- View Orders -->
                            <li>
                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                    My Orders
                                </a>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <!-- Logout -->
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
        </div>

    </div>
</nav>
