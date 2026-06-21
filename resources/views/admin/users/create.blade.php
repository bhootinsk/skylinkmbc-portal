<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.users.index') }}" class="text-sm text-skylink-700 hover:underline">&larr; Back to users</a>
        <h1 class="text-2xl font-semibold text-skylink-900 mt-2">Create user</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 max-w-xl">
        <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                       class="w-full rounded-lg border-slate-300 focus:border-skylink-500 focus:ring-skylink-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Full name</label>
                <input type="text" name="name" value="{{ old('name') }}" required
                       class="w-full rounded-lg border-slate-300 focus:border-skylink-500 focus:ring-skylink-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                       class="w-full rounded-lg border-slate-300 focus:border-slate-300 focus:ring-skylink-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Role</label>
                <select name="role" class="w-full rounded-lg border-slate-300 focus:border-skylink-500 focus:ring-skylink-500">
                    @foreach ($roles as $role)
                        <option value="{{ $role->value }}" @selected(old('role') === $role->value)>{{ $role->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required
                       class="w-full rounded-lg border-slate-300 focus:border-skylink-500 focus:ring-skylink-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Confirm password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full rounded-lg border-slate-300 focus:border-skylink-500 focus:ring-skylink-500">
            </div>

            <button type="submit" class="rounded-lg bg-skylink-700 hover:bg-skylink-800 text-white px-4 py-2.5 font-medium">
                Create user
            </button>
        </form>
    </div>
</x-admin-layout>
