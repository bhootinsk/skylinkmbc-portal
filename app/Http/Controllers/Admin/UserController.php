<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        $users = User::query()
            ->orderByRaw("CASE role WHEN 'superadmin' THEN 0 WHEN 'admin' THEN 1 ELSE 2 END")
            ->orderBy('name')
            ->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    public function create(): View
    {
        return view('admin.users.create', [
            'roles' => [UserRole::Admin, UserRole::Client],
        ]);
    }

    public function store(StoreUserRequest $request, ActivityLogger $logger): RedirectResponse
    {
        $user = User::create([
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'role' => UserRole::from($request->input('role')),
            'password' => $request->input('password'),
            'email_verified_at' => now(),
        ]);

        $logger->log('user.created', Auth::guard('admin')->user(), null, $request, [
            'created_user_id' => $user->id,
            'role' => $user->role->value,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User created successfully.');
    }

    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => [UserRole::Admin, UserRole::Client],
        ]);
    }

    public function update(UpdateUserRequest $request, User $user, ActivityLogger $logger): RedirectResponse
    {
        $data = [
            'username' => $request->input('username'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        if ($request->filled('password')) {
            $data['password'] = $request->input('password');
        }

        if (! $user->is_protected && $request->filled('role')) {
            $data['role'] = UserRole::from($request->input('role'));
        }

        $user->update($data);

        $logger->log('user.updated', Auth::guard('admin')->user(), null, $request, [
            'updated_user_id' => $user->id,
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User updated successfully.');
    }

    public function suspend(User $user, ActivityLogger $logger): RedirectResponse
    {
        abort_unless($user->canBeModified(), 403, 'This account cannot be suspended.');

        $user->update(['is_suspended' => true]);

        $logger->log('user.suspended', Auth::guard('admin')->user(), null, request(), [
            'suspended_user_id' => $user->id,
        ]);

        return back()->with('status', 'User suspended.');
    }

    public function activate(User $user, ActivityLogger $logger): RedirectResponse
    {
        abort_unless($user->canBeModified(), 403, 'This account cannot be modified.');

        $user->update(['is_suspended' => false]);

        $logger->log('user.activated', Auth::guard('admin')->user(), null, request(), [
            'activated_user_id' => $user->id,
        ]);

        return back()->with('status', 'User activated.');
    }

    public function destroy(User $user, ActivityLogger $logger): RedirectResponse
    {
        abort_unless($user->canBeModified(), 403, 'This account cannot be deleted.');

        $logger->log('user.deleted', Auth::guard('admin')->user(), null, request(), [
            'deleted_user_id' => $user->id,
            'deleted_email' => $user->email,
        ]);

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('status', 'User deleted.');
    }
}
