<?php

namespace App\Http\Controllers;

use App\Events\UsernameChanged;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;

class UsernameController extends Controller
{
    public function update(Request $request): Redirector|Application|RedirectResponse
    {
        $data =  $request->validate(['username' => ['required', 'string', 'alpha_dash', 'between:5,25', 'unique:users']]);

        auth()->user()->update(['username' => $data['username']]);

        event(new UsernameChanged(auth()->user()));

        return redirect('/home')->with('flash', 'Username Updated Successfully');
    }
}
