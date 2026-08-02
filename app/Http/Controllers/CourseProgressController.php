<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseProgressResource;
use App\Models\Course;
use App\Services\CourseProgressService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class CourseProgressController extends Controller
{
    public function __construct(
        private CourseProgressService $progressService
    ) {
    }

    #[OA\Get(
        path: "/api/courses/{course}/progress",
        summary: "Get course progress",
        description: "Returns the authenticated student's progress for a course.",
        tags: ["Course Progress"],

        security: [
            ["sanctum" => []]
        ],

        parameters: [
            new OA\Parameter(
                name: "course",
                description: "Course ID",
                in: "path",
                required: true,
                schema: new OA\Schema(
                    type: "integer",
                    example: 1
                )
            )
        ],

        responses: [

            new OA\Response(
                response: 200,
                description: "Course progress retrieved successfully",

                content: new OA\JsonContent(
                    properties: [

                        new OA\Property(
                            property: "data",
                            properties: [

                                new OA\Property(
                                    property: "total_lessons",
                                    type: "integer",
                                    example: 20
                                ),

                                new OA\Property(
                                    property: "completed_lessons",
                                    type: "integer",
                                    example: 8
                                ),

                                new OA\Property(
                                    property: "progress_percentage",
                                    type: "number",
                                    example: 40
                                ),
                            ],
                            type: "object"
                        ),
                    ]
                )
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "Forbidden"
            ),
        ]
    )]
    public function show(Request $request, Course $course)
    {
        $this->authorize('viewProgress', $course);

        $progress = $this->progressService->calculate(
            $request->user(),
            $course
        );

        return new CourseProgressResource($progress);
    }
}