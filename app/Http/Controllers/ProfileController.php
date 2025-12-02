<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class ProfileController extends Controller
{
    public function show(User $user): Application|Factory|View
    {
        $profile = $user->profile->load('user');

        $isFollowing = (request()->user()) ? $profile->follower->contains(auth()->id()) : false;

        return view('profiles.show', ['profile' => $profile, 'isFollowing' => $isFollowing]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(Request $request, User $user): int
    {
        $this->authorize('update', $user->profile);

        $validatedRequest = $request->validate([
            'name' => ['required', 'string', 'min:5'],
            'bio' => ['required', 'string', 'min:12'],
        ]);

        return $user->profile()->update($validatedRequest);
    }
}
