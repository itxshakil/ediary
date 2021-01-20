<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        $profile = $user->profile->load('user');

        $isFollowing = (auth()->user()) ? $profile->follower->contains(auth()->id()) : false;

        return view('profiles.show', compact('profile', 'isFollowing'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $profile = $user->profile;

        return view('profiles.edit', compact('profile'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user->profile);

        $data = $request->validate([
            'name' => ['required', 'string', 'min:5'],
            'bio' => ['required', 'string', 'min:12'],
        ]);

        return $user->profile()->update($data);
    }
}
