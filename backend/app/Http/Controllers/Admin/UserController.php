<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\AuditLog;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::with(['roles', 'sellerProfile'])->withCount('listings');

        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $roleSlug = $request->input('role');
            $query->whereHas('roles', fn ($q) => $q->where('slug', $roleSlug));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $users = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::all();

        return view('admin.users.index', compact('users', 'roles'));
    }

    public function show(User $user): View
    {
        $user->load(['roles', 'sellerProfile', 'listings' => fn ($q) => $q->latest()->take(10)]);
        $recentLogs = AuditLog::where(function ($q) use ($user) {
            $q->where('actor_id', $user->id)
              ->orWhere(fn ($sq) => $sq->where('entity_type', User::class)->where('entity_id', $user->id));
        })->latest()->take(10)->get();

        return view('admin.users.show', compact('user', 'recentLogs'));
    }

    public function edit(User $user): View
    {
        $roles = Role::all();
        $userRoleIds = $user->roles->pluck('id')->toArray();

        return view('admin.users.edit', compact('user', 'roles', 'userRoleIds'));
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        DB::transaction(function () use ($request, $user) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            $user->status = $request->input('status', 'active');

            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            $user->save();

            // Privilege check: Only super-admin can assign or change super-admin role
            if (Auth::user()->isSuperAdmin() && $request->has('roles')) {
                $user->roles()->sync($request->input('roles'));
            } elseif ($request->has('roles')) {
                $superAdminRole = Role::where('slug', 'super-admin')->first();
                $roles = collect($request->input('roles'))
                    ->reject(fn ($id) => $superAdminRole && (int) $id === $superAdminRole->id)
                    ->toArray();
                $user->roles()->sync($roles);
            }

            AuditLog::record(
                'user.updated',
                User::class,
                $user->id,
                ['updated_fields' => array_keys($request->validated())]
            );
        });

        return redirect()->route('admin.users.show', $user)->with('success', "User '{$user->name}' updated successfully.");
    }

    public function toggleStatus(Request $request, User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot change your own account status.');
        }

        $newStatus = $user->status === 'active' ? 'blocked' : 'active';
        $user->update(['status' => $newStatus]);

        AuditLog::record(
            "user.status_{$newStatus}",
            User::class,
            $user->id,
            ['previous_status' => $user->status, 'new_status' => $newStatus]
        );

        return back()->with('success', "User status updated to {$newStatus}.");
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->isSuperAdmin()) {
            return back()->with('error', 'Super Admin accounts cannot be deleted.');
        }

        DB::transaction(function () use ($user) {
            AuditLog::record('user.deleted', User::class, $user->id, ['email' => $user->email, 'name' => $user->name]);
            $user->delete();
        });

        return redirect()->route('admin.users.index')->with('success', "User account removed successfully.");
    }
}
