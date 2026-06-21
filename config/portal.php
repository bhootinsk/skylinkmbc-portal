<?php

return [

    'admin_notify_email' => env('ADMIN_NOTIFY_EMAIL', 'admin@skylinkmbc.biz'),

    'website_url' => env('PORTAL_WEBSITE_URL', 'https://skylinkmbc.biz'),

    'logo_url' => env('PORTAL_LOGO_URL'),

    'max_upload_size_kb' => (int) env('PORTAL_MAX_UPLOAD_KB', 51200),

    'allowed_extensions' => ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'zip'],

    'allowed_mimes' => [
        'pdf' => 'application/pdf',
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'zip' => 'application/zip',
    ],

];
