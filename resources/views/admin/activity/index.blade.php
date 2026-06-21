<x-admin-layout>
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-skylink-900">Activity log</h1>
        <p class="text-sm text-slate-600 mt-1">Audit trail of portal actions.</p>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium">Time</th>
                        <th class="text-left px-6 py-3 font-medium">User</th>
                        <th class="text-left px-6 py-3 font-medium">Action</th>
                        <th class="text-left px-6 py-3 font-medium">File</th>
                        <th class="text-left px-6 py-3 font-medium">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($logs as $log)
                        <tr>
                            <td class="px-6 py-3 text-slate-600 whitespace-nowrap">{{ $log->created_at->format('M j, Y g:i A') }}</td>
                            <td class="px-6 py-3">{{ $log->user?->name ?? '—' }}</td>
                            <td class="px-6 py-3">{{ $log->actionLabel() }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $log->clientFile?->original_name ?? '—' }}</td>
                            <td class="px-6 py-3 text-slate-500 font-mono text-xs">{{ $log->ip_address ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">No activity recorded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">{{ $logs->links() }}</div>
        @endif
    </div>
</x-admin-layout>
