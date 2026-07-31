<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "User",
    type: "object",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            example: 1
        ),
        new OA\Property(
            property: "name",
            type: "string",
            example: "Hamid"
        ),
        new OA\Property(
            property: "email",
            type: "string",
            example: "hamid@test.com"
        ),
        new OA\Property(
            property: "role",
            type: "string",
            example: "student"
        )
    ]
)]

#[OA\Schema(
    schema: "AuthResponse",
    type: "object",
    properties: [
        new OA\Property(
            property: "message",
            type: "string",
            example: "User registered successfully"
        ),

        new OA\Property(
            property: "data",
            type: "object",
            properties: [
                new OA\Property(
                    property: "user",
                    ref: "#/components/schemas/User"
                ),

                new OA\Property(
                    property: "token",
                    type: "string",
                    example: "1|a8s7d9f6g5h4"
                ),
            ]
        ),
    ]
)]

class Schemas
{
}