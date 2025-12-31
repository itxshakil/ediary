<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

final class UsernameController extends Controller
{
    public function checkUsernameAvailability(Request $request): \Illuminate\Http\JsonResponse
    {
        if (mb_strlen($request->username) < 5 || User::isUsernameTaken($request->username)) {
            return response()->json([
                'success' => false,
                'message' => 'Username is not available.',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Username is available.',
        ]);
    }
}
