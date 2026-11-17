<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsurePortalAdminAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Session Authentication Check
        if (! Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }
            return redirect()->route('portal-admin.login')
                ->with('warning', 'Please sign in with your PlaceX Portal staff credentials.');
        }

        $user = Auth::user();

        // 2. Account Active Status Check
        if ($user->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('portal-admin.login')
                ->withErrors(['email' => 'Your staff account has been deactivated or suspended.']);
        }

        // 3. Portal Staff Role Authorization Check
        // Accepts: portal-manager, content-manager, listing-manager, moderator, support-agent, super-admin, admin
        $portalRoles = [
            'portal-manager',
            'content-manager',
            'listing-manager',
            'moderator',
            'support-agent',
            'super-admin',
            'admin',
        ];

        if (! $user->hasAnyRole($portalRoles) && ! $user->hasPermission('portal.access')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized portal access.'], 403);
            }
            abort(403, 'Unauthorized. Your account does not possess PlaceX Portal Administration credentials.');
        }

        return $next($request);
    }
}
