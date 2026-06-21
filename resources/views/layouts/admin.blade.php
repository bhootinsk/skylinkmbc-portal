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
            <div class="px-6 py-5 border-b border-skylink-800">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg bg-skylink-700 flex items-center justify-center font-bold text-sm">SL</div>
                    <div>
                        <p class="font-semibold">SkyLink MBC</p>
                        <p class="text-xs text-skylink-300">Admin Portal</p>
                    </div>
                </div>
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
            <div class="px-4 py-4 border-t border-skylink-800 text-xs text-skylink-300 space-y-2">
                <p>{{ auth('admin')->user()->name }}</p>
                <a href="{{ config('portal.website_url') }}" class="block hover:text-white">&larr; Back to website</a>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-slate-200 px-4 sm:px-6 py-4 flex items-center justify-between md:hidden">
                <p class="font-semibold text-skylink-900">Admin Portal</p>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="text-sm text-slate-600">Sign out</button>
                </form>
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

            <footer class="px-6 py-3 text-xs text-slate-500 border-t border-slate-200 bg-white flex justify-between">
                <span>&copy; {{ date('Y') }} SkyLink MBC</span>
                <form method="POST" action="{{ route('admin.logout') }}" class="hidden md:block">
                    @csrf
                    <button type="submit" class="hover:text-slate-800">Sign out</button>
                </form>
            </footer>
        </div>
    </div>
</body>
</html>
