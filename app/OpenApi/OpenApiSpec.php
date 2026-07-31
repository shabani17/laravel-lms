<?php

namespace App\OpenApi;

use OpenApi\Attributes as OA;

#[OA\Info(
    title: "LMS API",
    version: "1.0.0",
    description: "API documentation for Laravel LMS project"
)]

#[OA\Server(
    url: "http://127.0.0.1:8000",
    description: "Local Development Server"
)]

#[OA\SecurityScheme(
    securityScheme: "sanctum",
    type: "http",
    scheme: "bearer",
    bearerFormat: "JWT"
)]

class OpenApiSpec
{
}