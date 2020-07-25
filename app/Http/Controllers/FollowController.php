<?php

namespace App\Http\Controllers;

use App\User;

class FollowController
{
    public function store(User $user)
    {
        return $user->profile->follower()->toggle(auth()->id());
    }
}
