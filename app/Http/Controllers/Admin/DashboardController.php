<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\ClientFile;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'clientCount' => User::where('role', 'client')->count(),
            'fileCount' => ClientFile::count(),
            'recentActivity' => ActivityLog::with(['user', 'clientFile'])
                ->latest('created_at')
                ->limit(10)
                ->get(),
        ]);
    }
}
