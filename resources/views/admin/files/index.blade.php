<x-admin-layout>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-skylink-900">Files</h1>
            <p class="text-sm text-slate-600 mt-1">All client documents stored in the portal.</p>
        </div>
        <a href="{{ route('admin.files.create') }}"
           class="inline-flex items-center justify-center rounded-lg bg-skylink-700 hover:bg-skylink-800 text-white px-4 py-2 text-sm font-medium">
            Upload for client
        </a>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-6 py-3 font-medium">File</th>
                        <th class="text-left px-6 py-3 font-medium">Client</th>
                        <th class="text-left px-6 py-3 font-medium">Uploaded by</th>
                        <th class="text-left px-6 py-3 font-medium">Date</th>
                        <th class="text-right px-6 py-3 font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($files as $file)
                        <tr>
                            <td class="px-6 py-3">
                                <p class="font-medium">{{ $file->original_name }}</p>
                                <p class="text-xs text-slate-500">{{ $file->humanSize() }}</p>
                            </td>
                            <td class="px-6 py-3">{{ $file->user->name }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $file->uploader?->name ?? '—' }}</td>
                            <td class="px-6 py-3 text-slate-600">{{ $file->created_at->format('M j, Y') }}</td>
                            <td class="px-6 py-3 text-right space-x-2">
                                <a href="{{ route('admin.files.download', $file) }}" class="text-skylink-700 hover:underline">Download</a>
                                <form method="POST" action="{{ route('admin.files.destroy', $file) }}" class="inline"
                                      onsubmit="return confirm('Delete this file?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-slate-500">No files uploaded yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($files->hasPages())
            <div class="px-6 py-4 border-t border-slate-200">{{ $files->links() }}</div>
        @endif
    </div>
</x-admin-layout>
