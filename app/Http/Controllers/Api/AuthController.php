<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register(
            $request->validated()
        );

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $result
        ], 201);
    }

    public function login(LoginRequest $request)
    {
        $result = $this->authService->login(
            $request->validated()
        );

        return response()->json([
            'message' => 'User logged in successfully',
            'data' => $result,
        ]);
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json([
            'message'=> "User logged out successfully"
        ]);
    }
}
