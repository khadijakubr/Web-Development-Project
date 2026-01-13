<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Authentication') - {{ config('app.name', 'My Shop') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        * {
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="flex items-center justify-center min-h-screen px-4 py-8">
        <div class="w-full max-w-md">
            @if(session('status'))
                <div class="mb-6 p-4 bg-gray-100 text-gray-800 rounded-lg border border-gray-200 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-gray-100 text-gray-800 rounded-lg border border-gray-200">
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</body>
</html>
