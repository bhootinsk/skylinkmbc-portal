<x-portal-layout area="Client Portal">
    <div class="max-w-5xl mx-auto px-4 py-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-semibold text-skylink-900">Welcome, {{ auth('web')->user()->name }}</h1>
                <p class="text-slate-600 text-sm mt-1">Upload, download, and manage your secure documents.</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-slate-600 hover:text-slate-900 underline">Sign out</button>
            </form>
        </div>

        @include('components.flash-messages')

        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6">
                    <h2 class="font-semibold text-skylink-900 mb-4">Upload a file</h2>
                    <form method="POST" action="{{ route('client.files.store') }}" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <input type="file" name="file" required
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                                   class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-skylink-50 file:text-skylink-800 file:font-medium hover:file:bg-skylink-100">
                            <p class="text-xs text-slate-500 mt-2">PDF, DOC, DOCX, JPG, PNG, ZIP — max 50 MB</p>
                        </div>
                        <button type="submit" class="w-full rounded-lg bg-skylink-700 hover:bg-skylink-800 text-white py-2.5 font-medium">
                            Upload
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-200">
                        <h2 class="font-semibold text-skylink-900">Your files</h2>
                    </div>

                    @if ($files->isEmpty())
                        <div class="px-6 py-12 text-center text-slate-500 text-sm">
                            No files yet. Upload your first document using the form.
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead class="bg-slate-50 text-slate-600">
                                    <tr>
                                        <th class="text-left px-6 py-3 font-medium">Name</th>
                                        <th class="text-left px-6 py-3 font-medium">Size</th>
                                        <th class="text-left px-6 py-3 font-medium">Uploaded</th>
                                        <th class="text-right px-6 py-3 font-medium">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100">
                                    @foreach ($files as $file)
                                        <tr>
                                            <td class="px-6 py-3 font-medium text-slate-800">{{ $file->original_name }}</td>
                                            <td class="px-6 py-3 text-slate-600">{{ $file->humanSize() }}</td>
                                            <td class="px-6 py-3 text-slate-600">{{ $file->created_at->format('M j, Y g:i A') }}</td>
                                            <td class="px-6 py-3 text-right space-x-3">
                                                <a href="{{ route('client.files.download', $file) }}"
                                                   class="text-skylink-700 hover:underline">Download</a>
                                                <form method="POST" action="{{ route('client.files.destroy', $file) }}" class="inline"
                                                      onsubmit="return confirm('Delete this file permanently?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-portal-layout>
