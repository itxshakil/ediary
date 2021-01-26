<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UsernameController extends Controller
{
    public function checkUsernameAvailability(Request $request): Response|Application|ResponseFactory
    {
        if (strlen($request->username) < 5 || User::isUsernameTaken($request->username)) {
            return response('', 422);
        }

        return response('', 200);
    }
}
