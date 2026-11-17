<?php

namespace App\Http\Controllers\PortalAdmin\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class PortalAuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check() && (Auth::user()->hasAnyRole([
            'portal-manager', 'content-manager', 'listing-manager', 'moderator', 'support-agent', 'super-admin', 'admin'
        ]) || Auth::user()->hasPermission('portal.access'))) {
            return redirect()->route('portal-admin.dashboard');
        }

        return view('portal-admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();

            if ($user->status !== 'active') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors(['email' => 'Your staff account has been deactivated or suspended.']);
            }

            $portalRoles = [
                'portal-manager', 'content-manager', 'listing-manager', 'moderator', 'support-agent', 'super-admin', 'admin'
            ];

            if (! $user->hasAnyRole($portalRoles) && ! $user->hasPermission('portal.access')) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors(['email' => 'Your account does not possess PlaceX Portal Admin credentials.']);
            }

            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            AuditLog::record('portal.login', User::class, $user->id, [
                'role' => $user->roles->pluck('slug')->toArray(),
                'ip' => $request->ip(),
                'agent' => $request->userAgent(),
            ]);

            return redirect()->intended(route('portal-admin.dashboard'))
                ->with('success', "Welcome back to PlaceX Portal, {$user->name}!");
        }

        RateLimiter::hit($throttleKey, 60);

        return back()->withErrors([
            'email' => 'Invalid staff credentials provided.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        AuditLog::record('portal.logout', User::class, $userId ?? 0, [
            'ip' => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('portal-admin.login')
            ->with('info', 'You have been signed out from PlaceX Portal Admin.');
    }
}
