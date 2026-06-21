<x-portal-layout area="Admin Portal">
    <div class="max-w-md mx-auto px-4 py-12">
        <div class="flex justify-center mb-6">
            <x-brand-logo :showName="false" size="lg" />
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
            <h1 class="text-2xl font-semibold text-skylink-900 mb-2">Admin Login</h1>
            <p class="text-sm text-slate-600 mb-6">Staff access to the SkyLink MBC portal administration area.</p>

            @include('components.flash-messages')

            <form method="POST" action="{{ route('admin.login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-lg border-slate-300 focus:border-skylink-500 focus:ring-skylink-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                           class="w-full rounded-lg border-slate-300 focus:border-skylink-500 focus:ring-skylink-500">
                </div>

                <label class="flex items-center gap-2 text-sm text-slate-600">
                    <input type="checkbox" name="remember" class="rounded border-slate-300 text-skylink-600 focus:ring-skylink-500">
                    Remember me
                </label>

                <button type="submit"
                        class="w-full rounded-lg bg-skylink-700 hover:bg-skylink-800 text-white font-medium py-2.5 transition">
                    Sign in
                </button>
            </form>

            <p class="mt-6 text-sm text-slate-500 text-center">
                <a href="{{ route('login') }}" class="text-skylink-700 hover:underline">Client login</a>
            </p>
        </div>
    </div>
</x-portal-layout>
