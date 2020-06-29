<?php

namespace App\Http\Controllers;

use App\User;

class FollowController extends Controller
{
    public function store(User $user)
    {
        return $user->profile->follower()->toggle(auth()->id());
    }
}
