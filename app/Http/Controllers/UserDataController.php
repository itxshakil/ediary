<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;

final class UserDataController extends Controller
{
    public function send(): StreamedResponse
    {
        $user = request()->user()->load('profile')->load('diaries');

        return response()->streamDownload(function () use ($user): void {
            echo $user;
        }, $user->username . '.json');
    }
}
