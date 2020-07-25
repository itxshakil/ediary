<?php

namespace App\Http\Controllers;

use App\Events\UsernameChanged;
use App\User;
use Illuminate\Http\Request;

class UsernameController extends Controller
{
    public function checkUsernameAvailibility(Request $request)
    {
        if (strlen($request->username) < 5 || User::isUsernameTaken($request->username)) {
            return response('false');
        }

        return response('true');
    }

    public function update(Request $request)
    {
        $data =  $request->validate(['username' => ['required', 'string', 'alpha_dash', 'between:5,25', 'unique:users']]);

        auth()->user()->update(['username' => $data['username']]);

        event(new UsernameChanged(auth()->user()));

        return redirect('/home')->with('flash', 'Username Updated Successfully');
    }
}
