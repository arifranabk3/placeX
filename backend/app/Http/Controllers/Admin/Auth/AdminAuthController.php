<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check() && Auth::user()->isAdminStaff()) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $throttleKey = Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            AuditLog::log('admin_login_rate_limited', 'User', null, ['email' => $request->input('email'), 'wait_seconds' => $seconds]);
            throw ValidationException::withMessages([
                'email' => [trans('auth.throttle', ['seconds' => $seconds, 'minutes' => ceil($seconds / 60)])],
            ]);
        }

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (!Auth::attempt($credentials, $remember)) {
            RateLimiter::hit($throttleKey, 120);
            AuditLog::log('admin_login_failed', 'User', null, ['email' => $request->input('email')]);
            throw ValidationException::withMessages([
                'email' => [__('The provided credentials do not match our administrative records.')],
            ]);
        }

        $user = Auth::user();

        // 1. Account status verification
        if ($user->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->with('error', 'Your administrative account has been deactivated or suspended.');
        }

        // 2. Staff Authorization Verification
        if (!$user->isAdminStaff()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            AuditLog::log('admin_login_unauthorized_role', 'User', $user->id, ['email' => $user->email]);

            return redirect()->route('admin.login')
                ->with('error', 'Access denied. You do not possess the required administrative credentials.');
        }

        // Success: Clear rate limiter and regenerate session
        RateLimiter::clear($throttleKey);
        $request->session()->regenerate();

        AuditLog::log('admin_login_success', 'User', $user->id, [
            'email' => $user->email,
            'roles' => $user->roles->pluck('slug')->toArray(),
        ]);

        return redirect()->intended(route('admin.dashboard'))
            ->with('success', "Welcome back, {$user->name}. Administrative session authenticated.");
    }

    public function logout(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        AuditLog::log('admin_logout', 'User', $userId);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been securely signed out of the PlaceX Admin Panel.');
    }

    public function showForgotPasswordForm(): View
    {
        return view('admin.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate(['email' => ['required', 'email']]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !$user->isAdminStaff()) {
            return back()->with('status', 'If an active administrative account exists with that email address, password reset instructions have been dispatched.');
        }

        // Generate reset token
        $status = Password::sendResetLink($request->only('email'));

        AuditLog::log('admin_password_reset_requested', 'User', $user->id, ['email' => $request->email]);

        return back()->with('status', __($status));
    }

    public function showResetPasswordForm(Request $request, ?string $token = null): View
    {
        return view('admin.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                AuditLog::log('admin_password_reset_completed', 'User', $user->id);
            }
        );

        return $status == Password::PASSWORD_RESET
            ? redirect()->route('admin.login')->with('success', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
