<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Admin — '.config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-100 text-slate-800">
    <div class="min-h-screen flex">
        <aside class="w-64 bg-skylink-950 text-white flex-shrink-0 hidden md:flex md:flex-col">
            <div class="px-5 py-5 border-b border-skylink-800">
                <a href="{{ route('admin.dashboard') }}" class="block hover:opacity-90 transition">
                    <x-brand-logo variant="light" area="Admin Portal" size="sm" />
                </a>
            </div>
            <nav class="flex-1 px-4 py-4 space-y-1 text-sm">
                <a href="{{ route('admin.dashboard') }}"
                   class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.dashboard') ? 'bg-skylink-800 text-white' : 'text-skylink-100 hover:bg-skylink-900' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                   class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.users.*') ? 'bg-skylink-800 text-white' : 'text-skylink-100 hover:bg-skylink-900' }}">
                    Users
                </a>
                <a href="{{ route('admin.files.index') }}"
                   class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.files.*') ? 'bg-skylink-800 text-white' : 'text-skylink-100 hover:bg-skylink-900' }}">
                    Files
                </a>
                <a href="{{ route('admin.activity.index') }}"
                   class="block rounded-lg px-3 py-2 {{ request()->routeIs('admin.activity.*') ? 'bg-skylink-800 text-white' : 'text-skylink-100 hover:bg-skylink-900' }}">
                    Activity Log
                </a>
            </nav>
            <div class="px-4 py-4 border-t border-skylink-800 space-y-3">
                <p class="text-xs text-skylink-300 truncate">{{ auth('admin')->user()->name }}</p>
                <a href="{{ config('portal.website_url') }}" class="block text-xs text-skylink-300 hover:text-white">&larr; Back to website</a>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-lg bg-skylink-800 hover:bg-skylink-700 border border-skylink-700 px-4 py-2.5 text-sm font-medium text-white transition">
                        Sign out
                    </button>
                </form>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-4 flex items-center justify-between">
                <div class="min-w-0">
                    <p class="font-semibold text-skylink-900 truncate">{{ $heading ?? 'Admin Portal' }}</p>
                    @isset($subheading)
                        <p class="text-xs text-slate-500 mt-0.5 truncate">{{ $subheading }}</p>
                    @endisset
                </div>
                <div class="flex items-center gap-3 flex-shrink-0">
                    <span class="hidden sm:inline text-sm text-slate-600">{{ auth('admin')->user()->name }}</span>
                    <form method="POST" action="{{ route('admin.logout') }}" class="md:hidden">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center rounded-lg bg-skylink-700 hover:bg-skylink-800 px-3.5 py-2 text-sm font-medium text-white transition">
                            Sign out
                        </button>
                    </form>
                </div>
            </header>

            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <div class="max-w-6xl mx-auto">
                    @if (session('status'))
                        <div class="mb-4 rounded-lg bg-emerald-50 border border-emerald-200 px-4 py-3 text-sm text-emerald-800">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-800">
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{ $slot }}
                </div>
            </main>

            <footer class="px-6 py-3 text-xs text-slate-500 border-t border-slate-200 bg-white">
                &copy; {{ date('Y') }} SkyLink MBC
            </footer>
        </div>
    </div>
</body>
</html>
