<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Actions\User\GenerateUsernameAction;
use App\Http\Controllers\Controller;
use App\Support\Analytics;
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

    public function showRegistrationForm(): Factory|View
    {
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
        ]);

        event(new Registered($user));
        Auth::login($user);
        $analytics->track('sign_up', ['method' => 'email']);

        $welcome = "Welcome to Ediary! Your public username is @{$user->username}. You can change it in Settings once your email is verified.";

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $welcome,
                'redirect' => '/home',
            ], 201);
        }

        return redirect('/home')->with('success', $welcome);
    }
}
