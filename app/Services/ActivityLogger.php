<?php

namespace App\Services;

use App\Models\ActivityLog;
use App\Models\ClientFile;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogger
{
    public function log(
        string $action,
        ?User $user = null,
        ?ClientFile $file = null,
        ?Request $request = null,
        array $metadata = [],
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => $user?->id,
            'action' => $action,
            'client_file_id' => $file?->id,
            'ip_address' => $request?->ip(),
            'metadata' => $metadata ?: null,
            'created_at' => now(),
        ]);
    }
}
