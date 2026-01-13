<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'My Shop') }}</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Dark Mode CSS (loaded early) -->
    @vite(['resources/css/dark-mode.css'])
    
    <!-- Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/products.css', 'resources/css/fonts.css', 'resources/css/product-detail.css', 'resources/js/promo.js'])
    
    <!-- Reviews CSS -->
    <link href="{{ asset('css/reviews.css') }}" rel="stylesheet">
    
    <!-- Apply dark mode immediately -->
    <script>
        (function() {
            const isDarkMode = localStorage.getItem('darkMode') === 'enabled';
            const prefersDark = window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches;
            
            if (isDarkMode || (prefersDark && !localStorage.getItem('darkMode'))) {
                document.documentElement.classList.add('dark-mode');
            }
        })();
    </script>
</head>
<body>

    @include('components.navbar')

    <main class="container py-4">
        @include('components.flash-message')
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/dark-mode.js'])
</body>
</html>
