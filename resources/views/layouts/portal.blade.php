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
        <header class="bg-gradient-to-r from-skylink-950 via-skylink-900 to-skylink-800 text-white shadow-md">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between gap-4">
                <a href="{{ config('portal.website_url') }}" class="hover:opacity-90 transition min-w-0">
                    <x-brand-logo variant="light" :area="$area ?? 'Client Portal'" />
                </a>

                <div class="flex items-center gap-3 sm:gap-4 flex-shrink-0">
                    @auth('web')
                        <span class="hidden sm:inline text-sm text-skylink-200">{{ auth('web')->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center rounded-lg border border-white/30 bg-white/10 hover:bg-white/20 px-3.5 py-2 text-sm font-medium text-white transition">
                                Sign out
                            </button>
                        </form>
                    @endauth

                    <a href="{{ config('portal.website_url') }}"
                       class="text-sm text-skylink-200 hover:text-white font-medium whitespace-nowrap">
                        &larr; Back to website
                    </a>
                </div>
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
