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
class Schemas
{
}