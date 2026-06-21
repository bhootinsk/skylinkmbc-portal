<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreFileRequest;
use App\Models\ClientFile;
use App\Services\ActivityLogger;
use App\Services\ClientFileService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FileController extends Controller
{
    public function store(
        StoreFileRequest $request,
        ClientFileService $fileService,
        ActivityLogger $logger,
    ): RedirectResponse {
        $user = Auth::guard('web')->user();
        $clientFile = $fileService->store($request->file('file'), $user, $user);

        $logger->log('file.upload', $user, $clientFile, $request, [
            'filename' => $clientFile->original_name,
        ]);

        $fileService->notifyAdmin('upload', $clientFile, $user);

        return back()->with('status', 'File uploaded successfully.');
    }

    public function download(ClientFile $file, ActivityLogger $logger): StreamedResponse
    {
        $user = Auth::guard('web')->user();
        abort_unless($file->user_id === $user->id, 403);

        $logger->log('file.download', $user, $file, request());

        return Storage::disk($file->disk)->download($file->path, $file->original_name);
    }

    public function destroy(
        ClientFile $file,
        ClientFileService $fileService,
        ActivityLogger $logger,
    ): RedirectResponse {
        $user = Auth::guard('web')->user();
        abort_unless($file->user_id === $user->id, 403);

        $filename = $file->original_name;
        $fileService->notifyAdmin('delete', $file, $user);

        $logger->log('file.delete', $user, $file, request(), [
            'filename' => $filename,
        ]);

        $fileService->delete($file);

        return back()->with('status', 'File deleted.');
    }
}
