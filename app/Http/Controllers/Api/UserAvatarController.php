<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Events\ProfilePicChanged;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

final class UserAvatarController extends Controller
{
    public function store(User $user, Request $request): bool|string
    {
        $profile = $user->profile;
        $this->authorize('update', $profile);

        $request->validate(['image' => ['required', 'image']]);

        $path = $request->file('image')->store('images', 's3');

        Storage::disk('s3')->setVisibility($path, 'public');

        $profile->update([
            'image' => $path,
        ]);

        event(new ProfilePicChanged($profile->image));

        return $path;
    }
}
