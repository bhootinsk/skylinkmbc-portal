<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $user = Auth::guard('web')->user();
        $files = $user->clientFiles()->latest()->get();

        return view('client.dashboard', compact('files'));
    }
}
