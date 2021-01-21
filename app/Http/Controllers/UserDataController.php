<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\StreamedResponse;

class UserDataController extends Controller
{
    public function send(): StreamedResponse
    {
        $user = auth()->user()->load('profile')->load('diaries');

        return response()->streamDownload(function () use ($user) {
            echo $user;
        }, "{$user->username}.json");
    }
}
