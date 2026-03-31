<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\UsernameChanged;
use App\Http\Requests\UpdateUsernameRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

final class UsernameController extends Controller
{
    public function update(UpdateUsernameRequest $request): Redirector|Application|RedirectResponse
    {
        $request->user()->update($request->validated());

        event(new UsernameChanged($request->user()));

        return redirect('/home')->with('flash', 'Username Changed Successfully.');
    }
}
