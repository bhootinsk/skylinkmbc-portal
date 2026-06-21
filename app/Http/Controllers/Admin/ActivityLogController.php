<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(): View
    {
        $logs = ActivityLog::with(['user', 'clientFile'])
            ->latest('created_at')
            ->paginate(50);

        return view('admin.activity.index', compact('logs'));
    }
}
