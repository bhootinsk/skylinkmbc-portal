<x-admin-layout>
    <div class="mb-6">
        <a href="{{ route('admin.files.index') }}" class="text-sm text-skylink-700 hover:underline">&larr; Back to files</a>
        <h1 class="text-2xl font-semibold text-skylink-900 mt-2">Upload for client</h1>
    </div>

    <div class="bg-white rounded-xl border border-slate-200 p-6 max-w-xl">
        <form method="POST" action="{{ route('admin.files.store') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">Client</label>
                <select name="client_id" required class="w-full rounded-lg border-slate-300 focus:border-skylink-500 focus:ring-skylink-500">
                    <option value="">Select a client</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->name }} ({{ $client->email }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1">File</label>
                <input type="file" name="file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.zip"
                       class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-skylink-50 file:text-skylink-800">
                <p class="text-xs text-slate-500 mt-2">PDF, DOC, DOCX, JPG, PNG, ZIP — max 50 MB</p>
            </div>

            <button type="submit" class="rounded-lg bg-skylink-700 hover:bg-skylink-800 text-white px-4 py-2.5 font-medium">
                Upload file
            </button>
        </form>
    </div>
</x-admin-layout>
