<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Inventory Task') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    <link rel="stylesheet" href="https://cdn.tailwindcss.com">
    @endif
</head>


<body class="bg-gray-100 text-gray-900">

    <!-- Header -->
    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between">
            <a href="{{ route('home') }}" class="hover:text-gray-500 transition">
                <h1 class="text-xl font-semibold">Inventory Task</h1>
            </a>

            <div class="flex justify-end">
                @auth
                    <span class="inline-block py-1.5 text-sm">
                        {{ auth()->user()->name ?? '' }}  |
                    </span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="inline-block cursor-pointer hover:opacity-60 px-5 py-1.5 text-sm">Logout</button>
                    </form>
                    @can('view-dashboard')
                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 hover:opacity-60 text-sm">
                        Dashboard
                    </a>
                    @endcan
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 hover:opacity-60 text-sm">
                        Log in
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 py-6">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-10">
        <div class="max-w-7xl mx-auto px-4 py-4 text-sm text-gray-500">
            © {{ date('Y') }} Inventory Task
        </div>
    </footer>

    @stack('scripts')
</body>

</html>