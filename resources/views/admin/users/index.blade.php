<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-skylink-900">Users</h1>
            <p class="text-sm text-slate-600 mt-1">Create and manage client and admin accounts.</p>
        </div>
        <a href="{{ route('admin.users.create') }}"
           class="inline-flex items-center justify-center rounded-lg bg-skylink-700 hover:bg-skylink-800 text-white px-4 py-2 text-sm font-medium">
            Add user
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium">Name</th>
                        <th class="text-left px-6 py-3 font-medium">Username</th>
                        <th class="text-left px-6 py-3 font-medium">Email</th>
                        <th class="text-left px-6 py-3 font-medium">Role</th>
                        <th class="text-left px-6 py-3 font-medium">Status</th>
                        <th class="text-right px-6 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-3 font-medium">{{ $user->name }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $user->username }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $user->email }}</td>
                            <td class="px-6 py-3">{{ $user->role->label() }}</td>
                            <td class="px-6 py-3">
                                @if ($user->is_suspended)
                                    <span class="inline-flex rounded-full bg-amber-100 text-amber-800 px-2 py-0.5 text-xs font-medium">Suspended</span>
                                @else
                                    <span class="inline-flex rounded-full bg-emerald-100 text-emerald-800 px-2 py-0.5 text-xs font-medium">Active</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-right space-x-2">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-skylink-700 hover:underline">Edit</a>
                                @if ($user->canBeModified())
                                    @if ($user->is_suspended)
                                        <form method="POST" action="{{ route('admin.users.activate', $user) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-emerald-700 hover:underline">Activate</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.users.suspend', $user) }}" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-amber-700 hover:underline">Suspend</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline"
                                          onsubmit="return confirm('Delete this user and all their files?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @else
                                    <span class="text-xs text-slate-400">Protected</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">{{ $users->links() }}</div>
        @endif
    </div>
</x-admin-layout>
