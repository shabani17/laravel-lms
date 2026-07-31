<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Get(
    path: "/api/test",
    summary: "Test API",
    tags: ["Test"],
    responses: [
        new OA\Response(
            response: 200,
            description: "API working"
        )
    ]
)]
class Paths
{
    //
}