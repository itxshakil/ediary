<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function showForm(){
        return view('auth.passwords.change');
    }

    public function change(Request $request){
        $request->validate($this->rules());

        $this->changeUserPassword($request->password);

        return redirect('/home')->with('flash','Password Changed Successfully');
    }

    /**
     * Get the password confirmation validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'current-password' => ['required','password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    protected function changeUserPassword($password){
        $user = Auth::user();

        $user->password = Hash::make($password);
        $user->save();
    }
}
