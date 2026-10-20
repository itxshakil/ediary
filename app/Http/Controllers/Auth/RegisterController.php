<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\User\GenerateUsernameAction;
use App\Http\Controllers\Controller;
use App\Support\Analytics;
use App\Support\Timezone;
use App\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

final class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm(Request $request): Factory|View
    {
        // Prompt pages send guests here with ?next=/diaries/create?prompt=...; only that form is
        // accepted, so the parameter can't be used to redirect anywhere else.
        $next = $request->string('next')->toString();
        if (str_starts_with($next, '/diaries/create')) {
            $request->session()->put('url.intended', url($next));
        }

        return view('auth.register');
    }

    public function register(Request $request, GenerateUsernameAction $generateUsername, Analytics $analytics): RedirectResponse|JsonResponse
    {
        // Stored lowercase so the email works at login however it was typed.
        $request->merge(['email' => mb_strtolower(mb_trim((string) $request->input('email')))]);

        $validated = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', Password::min(8)],
        ]);

        $user = User::create([
            'username' => $generateUsername->execute(),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'timezone' => Timezone::fromBrowser($request->input('timezone')),
        ]);

        event(new Registered($user));
        Auth::login($user);
        $analytics->track('sign_up', ['method' => 'email']);

        $welcome = "Welcome to Ediary! Your public username is @{$user->username}. You can change it in Settings once your email is verified.";

        $redirect = redirect()->intended('/home')->with('success', $welcome);

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $welcome,
                'redirect' => $redirect->getTargetUrl(),
            ], 201);
        }

        return $redirect;
    }
}
