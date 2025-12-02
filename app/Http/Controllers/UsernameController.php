<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\UsernameChanged;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

final class UsernameController extends Controller
{
    public function update(Request $request): Redirector|Application|RedirectResponse
    {
        $validatedRequest = $request->validate(['username' => ['required', 'string', 'alpha_dash', 'between:5,25', 'unique:users']]);

        auth()->user()->update($validatedRequest);

        event(new UsernameChanged(auth()->user()));

        return redirect('/home')->with('flash', 'Username Changed Successfully.');
    }
}
