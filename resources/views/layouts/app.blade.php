<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', config('app.name'))</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        @endif
    </head>
    <body class="min-h-screen bg-zinc-50 text-zinc-900 antialiased">
        <header class="border-b border-zinc-200 bg-white">
            <div class="mx-auto flex max-w-3xl items-center justify-between px-6 py-4">
                <a href="{{ route('home') }}" class="text-lg font-semibold tracking-tight">
                    {{ config('app.name') }}
                </a>
                <nav class="flex items-center gap-6 text-sm font-medium">
                    <a href="{{ route('home') }}" class="text-zinc-600 hover:text-zinc-900">Blog</a>
                    <a href="{{ url('/admin') }}" class="text-zinc-600 hover:text-zinc-900">Admin</a>
                </nav>
            </div>
        </header>

        <main class="mx-auto max-w-3xl px-6 py-12">
            @yield('content')
        </main>

        <footer class="border-t border-zinc-200">
            <div class="mx-auto max-w-3xl px-6 py-8 text-sm text-zinc-500">
                {{ config('app.name') }} — a Laravel blog starter kit.
            </div>
        </footer>
    </body>
</html>
