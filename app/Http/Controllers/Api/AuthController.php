<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthService;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }


    #[OA\Post(
        path: "/api/register",
        summary: "Register a new user",
        tags: ["Authentication"],

        requestBody: new OA\RequestBody(
            required: true,
            description: "User registration data",
            content: new OA\JsonContent(
                required: [
                    "name",
                    "email",
                    "password",
                    "password_confirmation"
                ],

                properties: [
                    new OA\Property(
                        property: "name",
                        type: "string",
                        example: "Hamid"
                    ),

                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        example: "hamid@test.com"
                    ),

                    new OA\Property(
                        property: "password",
                        type: "string",
                        format: "password",
                        example: "password123"
                    ),

                    new OA\Property(
                        property: "password_confirmation",
                        type: "string",
                        format: "password",
                        example: "password123"
                    ),
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 201,
                description: "User registered successfully",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/AuthResponse"
                )
            ),

            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]

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


    #[OA\Post(
        path: "/api/login",
        summary: "Login user",
        tags: ["Authentication"],

        requestBody: new OA\RequestBody(
            required: true,
            description: "User login credentials",
            content: new OA\JsonContent(
                required: [
                    "email",
                    "password"
                ],

                properties: [
                    new OA\Property(
                        property: "email",
                        type: "string",
                        format: "email",
                        example: "hamid@test.com"
                    ),

                    new OA\Property(
                        property: "password",
                        type: "string",
                        format: "password",
                        example: "password123"
                    ),
                ]
            )
        ),

        responses: [
            new OA\Response(
                response: 200,
                description: "User logged in successfully",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/AuthResponse"
                )
            ),

            new OA\Response(
                response: 422,
                description: "Invalid credentials"
            )
        ]
    )]

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

    #[OA\Post(
    path: "/api/logout",
    summary: "Logout user",
    tags: ["Authentication"],

    security: [
        [
            "sanctum" => []
        ]
    ],

    responses: [
            new OA\Response(
                response: 200,
                description: "User logged out successfully",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(
                            property: "message",
                            type: "string",
                            example: "User logged out successfully"
                        )
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json([
            'message'=> "User logged out successfully"
        ]);
    }
}
