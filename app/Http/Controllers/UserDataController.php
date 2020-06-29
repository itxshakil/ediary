<?php

namespace App\Http\Controllers;

class UserDataController extends Controller
{
    public function send()
    {
        $user = auth()->user()->load('profile')->load('diaries');

        return response()->streamDownload(function () use ($user) {
            echo $user;
        }, "{$user->username}.json");
    }
}
