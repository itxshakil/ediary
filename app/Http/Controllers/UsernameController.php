<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsernameController extends Controller
{
    public function checkUsernameAvailibility(Request $request)
    {
        if (strlen($request->username) < 5) {
            return response('false');
        }

        if (User::where('username', $request->username)->exists()) {
            return response('false');
        }

        return response('true');
    }
}
