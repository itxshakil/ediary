<?php

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
use JetBrains\PhpStorm\ArrayShape;

class ChangePasswordController extends Controller
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

        $this->changeUserPassword($user=Auth::user(), $request->password);

        event(new PasswordChanged($user));

        return redirect('/home')->with('flash','Password Changed Successfully');
    }

    /**
     * Get the password confirmation validation rules.
     *
     * @return array
     */
    #[ArrayShape(['current-password' => "string[]", 'password' => "string[]"])]
    protected function rules(): array
    {
        return [
            'current-password' => ['required','password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    protected function changeUserPassword($user, $password){
        $user->password = Hash::make($password);
        $user->save();
    }
}
