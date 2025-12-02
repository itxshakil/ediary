<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Events\PasswordChanged;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final class ChangePasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showForm(): Factory|View|Application
    {
        return view('auth.passwords.change');
    }

    public function change(Request $request): Redirector|Application|RedirectResponse
    {
        $request->validate($this->rules());

        $this->changeUserPassword($user = Auth::user(), $request->password);

        event(new PasswordChanged($user));

        return redirect('/home')->with('flash', 'Password Changed Successfully');
    }

    /**
     * Get the password confirmation validation rules.
     *
     * @return array<string, string[]>
     */
    private function rules(): array
    {
        return [
            'current-password' => ['required', 'password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    private function changeUserPassword($user, $password): void
    {
        $user->password = Hash::make($password);
        $user->save();
    }
}
