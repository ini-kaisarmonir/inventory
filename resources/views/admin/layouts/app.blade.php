<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>

<body class="bg-gray-100 text-gray-900">

    <div class="min-h-screen flex flex-col">

        <!-- Top Navbar -->
        <header class="bg-white border-b shadow-sm">
            <div class="flex items-center justify-between px-6 py-3">
                <h1 class="text-lg font-semibold">
                    Inventory Task
                </h1>

                @auth
                <div class="flex items-center gap-1">
                    <span class="text-sm text-gray-600">
                        {{ auth()->user()->name ?? '' }} |
                    </span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button
                            class="text-sm text-red-600 hover:text-red-800 cursor-pointer transition">
                            Logout
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </header>

        <!-- Main Layout -->
        <div class="flex flex-1">

            @can('view-dashboard')
            @include('admin.sidebar')
            @endcan


            <main class="flex-1 p-6">
                @if (session('success'))
                <div class="mb-4 rounded bg-green-100 px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
                @endif

                @if (session('error'))
                <div class="mb-4 rounded bg-red-100 px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
                @endif
                <!-- Content Area -->
                @yield('content')
            </main>

        </div>
    </div>

</body>

</html>