<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $request->validate();

        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }


    public function logout(Request $request) : JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}
