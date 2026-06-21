<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreFileForClientRequest;
use App\Models\ClientFile;
use App\Models\User;
use App\Services\ActivityLogger;
use App\Services\ClientFileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function index(): View
    {
        $files = ClientFile::with(['user', 'uploader'])
            ->latest()
            ->paginate(25);

        return view('admin.files.index', compact('files'));
    }

    public function create(): View
    {
        $clients = User::where('role', 'client')
            ->where('is_suspended', false)
            ->orderBy('name')
            ->get();

        return view('admin.files.create', compact('clients'));
    }

    public function store(
        StoreFileForClientRequest $request,
        ClientFileService $fileService,
        ActivityLogger $logger,
    ): RedirectResponse {
        $client = User::findOrFail($request->integer('client_id'));
        abort_unless($client->isClient(), 422);

        $admin = Auth::guard('admin')->user();
        $clientFile = $fileService->store($request->file('file'), $client, $admin);

        $logger->log('file.upload', $admin, $clientFile, $request, [
            'filename' => $clientFile->original_name,
            'on_behalf_of' => $client->id,
        ]);

        return redirect()
            ->route('admin.files.index')
            ->with('status', 'File uploaded on behalf of '.$client->name.'.');
    }

    public function download(ClientFile $file, ActivityLogger $logger): StreamedResponse
    {
        $logger->log('file.download', Auth::guard('admin')->user(), $file, request());

        return Storage::disk($file->disk)->download($file->path, $file->original_name);
    }

    public function destroy(
        ClientFile $file,
        ClientFileService $fileService,
        ActivityLogger $logger,
    ): RedirectResponse {
        $admin = Auth::guard('admin')->user();

        $logger->log('file.delete', $admin, $file, request(), [
            'filename' => $file->original_name,
        ]);

        $fileService->delete($file);

        return back()->with('status', 'File deleted.');
    }
}
