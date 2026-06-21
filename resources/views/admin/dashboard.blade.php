<x-admin-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-semibold text-skylink-900">Dashboard</h1>
        <p class="text-slate-600 text-sm mt-1">Overview of portal activity and accounts.</p>
    </div>

    <div class="grid sm:grid-cols-2 gap-4 mb-8">
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <p class="text-sm text-slate-500">Active clients</p>
            <p class="text-3xl font-semibold text-skylink-900 mt-1">{{ $clientCount }}</p>
        </div>
        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <p class="text-sm text-slate-500">Total files</p>
            <p class="text-3xl font-semibold text-skylink-900 mt-1">{{ $fileCount }}</p>
        </div>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
            <h2 class="font-semibold text-skylink-900">Recent activity</h2>
            <a href="{{ route('admin.activity.index') }}" class="text-sm text-skylink-700 hover:underline">View all</a>
        </div>
        @if ($recentActivity->isEmpty())
            <p class="px-6 py-8 text-sm text-slate-500">No activity recorded yet.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-slate-50 text-slate-600">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium">Time</th>
                            <th class="text-left px-6 py-3 font-medium">User</th>
                            <th class="text-left px-6 py-3 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($recentActivity as $log)
                            <tr>
                                <td class="px-6 py-3 text-slate-600">{{ $log->created_at->format('M j, Y g:i A') }}</td>
                                <td class="px-6 py-3">{{ $log->user?->name ?? '—' }}</td>
                                <td class="px-6 py-3">{{ $log->actionLabel() }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-admin-layout>
