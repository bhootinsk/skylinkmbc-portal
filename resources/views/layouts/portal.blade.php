<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50 text-slate-800">
    <div class="min-h-screen flex flex-col">
        <header class="bg-white border-b border-slate-200 shadow-sm">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-skylink-700 flex items-center justify-center text-white font-bold text-sm">
                        SL
                    </div>
                    <div>
                        <p class="font-semibold text-skylink-900">SkyLink MBC</p>
                        <p class="text-xs text-slate-500">{{ $area ?? 'Client Portal' }}</p>
                    </div>
                </div>
                <a href="{{ config('portal.website_url') }}" class="text-sm text-skylink-700 hover:text-skylink-900 font-medium">
                    &larr; Back to website
                </a>
            </div>
        </header>

        <main class="flex-1">
            {{ $slot }}
        </main>

        <footer class="border-t border-slate-200 bg-white py-4 text-center text-xs text-slate-500">
            &copy; {{ date('Y') }} SkyLink MBC. All rights reserved.
        </footer>
    </div>
</body>
</html>
