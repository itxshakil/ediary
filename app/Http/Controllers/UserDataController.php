<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class UserDataController extends Controller
{
    public function send(Request $request): StreamedResponse
    {
        $user = $request->user()->load('profile', 'diaries');

        return response()->streamDownload(function () use ($user): void {
            echo $user->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        }, $user->username . '.json');
    }
}
