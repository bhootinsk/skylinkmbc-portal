<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'action',
        'client_file_id',
        'ip_address',
        'metadata',
        'created_at',
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'array',
            'created_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function clientFile(): BelongsTo
    {
        return $this->belongsTo(ClientFile::class);
    }

    public function actionLabel(): string
    {
        return match ($this->action) {
            'file.upload' => 'File uploaded',
            'file.download' => 'File downloaded',
            'file.delete' => 'File deleted',
            'user.login' => 'User login',
            'user.created' => 'User created',
            'user.updated' => 'User updated',
            'user.suspended' => 'User suspended',
            'user.activated' => 'User activated',
            'user.deleted' => 'User deleted',
            default => ucfirst(str_replace('.', ' ', $this->action)),
        };
    }
}
