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

#[OA\Schema(
    schema: "Course",
    type: "object",
    properties: [
        new OA\Property(
            property: "id",
            type: "integer",
            example: 1
        ),

        new OA\Property(
            property: "title",
            type: "string",
            example: "Laravel From Zero to Hero"
        ),

        new OA\Property(
            property: "slug",
            type: "string",
            example: "laravel-from-zero-to-hero"
        ),

        new OA\Property(
            property: "description",
            type: "string",
            example: "Complete Laravel course."
        ),

        new OA\Property(
            property: "price",
            type: "number",
            format: "float",
            example: 499.99
        ),

        new OA\Property(
            property: "level",
            type: "string",
            example: "beginner"
        ),

        new OA\Property(
            property: "status",
            type: "string",
            example: "published"
        )
    ]
)]

class Schemas
{
}