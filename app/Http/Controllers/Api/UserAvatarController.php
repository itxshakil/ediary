<?php

namespace App\Http\Controllers\Api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class UserAvatarController extends Controller
{
    public function store(User $user, Request $request)
    {
        $profile =  $user->profile;
        $this->authorize('update', $profile);

        $request->validate(['image' => ['required','image']]);
        
        $path = $request->file('image')->store('images', 's3');

        Storage::disk('s3')->setVisibility($path, 'public');
        
        return $profile->update([
            'image' =>  $path
        ]);
    }
}
