<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::with(['permissions', 'users'])->get();
        $permissions = Permission::all()->groupBy(function ($perm) {
            return explode('.', $perm->slug)[0] ?? 'general';
        });

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    public function updatePermissions(Request $request, Role $role): RedirectResponse
    {
        if ($role->slug === 'super-admin') {
            return back()->with('error', 'Super Admin permissions are hard-coded and cannot be modified.');
        }

        $validated = $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->permissions()->sync($validated['permissions'] ?? []);

        AuditLog::record(
            'role.permissions_updated',
            Role::class,
            $role->id,
            ['role' => $role->name, 'permission_count' => count($validated['permissions'] ?? [])]
        );

        return back()->with('success', "Permissions for role '{$role->name}' updated successfully.");
    }
}
