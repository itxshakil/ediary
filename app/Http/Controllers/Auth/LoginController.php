<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\Analytics;
use App\Support\Timezone;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

final class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(): Factory|View
    {
        return view('auth.login');
    }

    public function login(Request $request, Analytics $analytics): RedirectResponse
    {
        $validated = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // One field takes either: usernames can't contain "@", so it decides which column to match.
        $login = mb_trim($validated['login']);
        $credentials = str_contains($login, '@')
            ? ['email' => mb_strtolower($login), 'password' => $validated['password']]
            : ['username' => $login, 'password' => $validated['password']];

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'login' => __('auth.failed'),
            ]);
        }

        $request->session()->regenerate();

        // Follow the writer when they travel or move: reminders should land in their evening.
        $timezone = Timezone::fromBrowser($request->input('timezone'));
        if ($timezone !== null) {
            $request->user()->update(['timezone' => $timezone]);
        }

        $analytics->track('login', ['method' => 'password']);

        return redirect()->intended('/home');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
