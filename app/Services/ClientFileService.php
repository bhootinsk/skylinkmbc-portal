<?php

namespace App\Services;

use App\Models\ClientFile;
use App\Models\User;
use App\Notifications\ClientFileActivityNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ClientFileService
{
    public function storagePath(User $owner): string
    {
        return 'client-files/'.$owner->id;
    }

    public function store(UploadedFile $file, User $owner, ?User $uploadedBy = null): ClientFile
    {
        $storedName = Str::uuid()->toString().'.'.$file->getClientOriginalExtension();
        $path = $file->storeAs($this->storagePath($owner), $storedName, 'local');

        return ClientFile::create([
            'user_id' => $owner->id,
            'uploaded_by' => $uploadedBy?->id ?? $owner->id,
            'original_name' => $file->getClientOriginalName(),
            'stored_name' => $storedName,
            'disk' => 'local',
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
        ]);
    }

    public function delete(ClientFile $clientFile): void
    {
        Storage::disk($clientFile->disk)->delete($clientFile->path);
        $clientFile->delete();
    }

    public function notifyAdmin(string $action, ClientFile $file, User $actor): void
    {
        $email = config('portal.admin_notify_email');

        if (! $email) {
            return;
        }

        Notification::route('mail', $email)
            ->notify(new ClientFileActivityNotification($action, $file, $actor));
    }
}
