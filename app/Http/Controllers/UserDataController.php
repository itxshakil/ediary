<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
