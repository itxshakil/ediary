<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckUsernameAvailabilityRequest;
use App\User;
use Illuminate\Http\JsonResponse;

final class UsernameController extends Controller
{
    public function checkUsernameAvailability(CheckUsernameAvailabilityRequest $request): JsonResponse
    {
        $username = $request->string('username')->toString();

        if (User::isUsernameTaken($username)) {
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
