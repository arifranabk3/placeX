<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdminAccess
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->guest(route('admin.login'))
                ->with('warning', 'Please sign in to access the PlaceX Admin Panel.');
        }

        $user = Auth::user();

        // Account status check
        if ($user->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('error', 'Your administrative account has been deactivated or suspended. Please contact Super Admin.');
        }

        // Privilege check: Must possess at least one administrative staff role
        if (!$user->isAdminStaff()) {
            abort(403, 'Unauthorized access. PlaceX administrative privileges are required to view this area.');
        }

        return $next($request);
    }
}
