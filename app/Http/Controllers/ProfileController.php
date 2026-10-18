<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

final class ProfileController extends Controller
{
    public function show(Request $request, User $user): Application|Factory|View
    {
        $profile = $user->profile()->with('user', 'follower')->firstOrFail();
        $viewer = $request->user();
        $isFollowing = $viewer !== null && $profile->follower->contains($viewer->id);

        $publicEntries = $user->diaries()->public()->with('tags')->latest()->paginate(10);
        // Every entry is this person's, whose profile is already loaded.
        $user->setRelation('profile', $profile);
        foreach ($publicEntries as $publicEntry) {
            $publicEntry->setRelation('owner', $user);
        }

        return view('profiles.show', [
            'profile' => $profile,
            'isFollowing' => $isFollowing,
            'publicEntries' => $publicEntries,
        ]);
    }

    /**
     * @throws AuthorizationException
     */
    public function update(UpdateProfileRequest $request, User $user): int
    {
        $this->authorize('update', $user->profile);

        return $user->profile()->update($request->validated());
    }
}
