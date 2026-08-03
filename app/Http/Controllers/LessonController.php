<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Http\Resources\LessonProgressResource;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\LessonService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class LessonController extends Controller
{
    public function __construct(
        protected LessonService $lessonService
    ) {}

    #[OA\Get(
        path: "/api/courses/{course}/lessons",
        summary: "Get lessons of a course",
        tags: ["Lessons"],

        security: [
            ["sanctum" => []]
        ],

        parameters: [
            new OA\Parameter(
                name: "course",
                in: "path",
                required: true,
                description: "Course ID",
                schema: new OA\Schema(
                    type: "integer",
                    example: 1
                )
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Lessons retrieved successfully"
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "Unauthorized action"
            )
        ]
    )]
    public function index(Course $course)
    {
        $this->authorize('view', $course);

        return response()->json([
            'data' => LessonResource::collection(
                $this->lessonService->list($course)
            ),
        ]);
    }

    #[OA\Post(
        path: "/api/courses/{course}/lessons",
        summary: "Create a lesson",
        tags: ["Lessons"],

        security: [
            ["sanctum" => []]
        ],

        parameters: [
            new OA\Parameter(
                name: "course",
                in: "path",
                required: true,
                description: "Course ID",
                schema: new OA\Schema(
                    type: "integer",
                    example: 1
                )
            )
        ],

        requestBody: new OA\RequestBody(
            required: true,

            content: new OA\JsonContent(
                required: [
                    "title"
                ],

                properties: [

                    new OA\Property(
                        property: "title",
                        type: "string",
                        example: "Laravel Service Container"
                    ),

                    new OA\Property(
                        property: "description",
                        type: "string",
                        nullable: true,
                        example: "Learn Laravel container"
                    ),

                    new OA\Property(
                        property: "video",
                        type: "string",
                        format: "binary",
                        nullable: true,
                        example: "https://example.com/video.mp4"
                    ),

                    new OA\Property(
                        property: "order",
                        type: "integer",
                        nullable: true,
                        example: 1
                    ),

                    new OA\Property(
                        property: "is_free",
                        type: "boolean",
                        nullable: true,
                        example: false
                    ),

                    new OA\Property(
                        property: "duration",
                        type: "integer",
                        nullable: true,
                        example: 45
                    )
                ]
            )
        ),

        responses: [

            new OA\Response(
                response: 201,
                description: "Lesson created successfully"
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "Unauthorized action"
            ),

            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function store(LessonRequest $request, Course $course)
    {
        $this->authorize('createLesson', $course);

        $lesson = $this->lessonService->create(
            $course,
            $request->validated()
        );

        return response()->json([
            'message' => 'Lesson created successfully',
            'data' => new LessonResource($lesson),
        ], 201);
    }

    #[OA\Get(
        path: "/api/lessons/{lesson}",
        summary: "Get lesson details",
        tags: ["Lessons"],

        security: [
            ["sanctum" => []]
        ],

        parameters: [
            new OA\Parameter(
                name: "lesson",
                in: "path",
                required: true,
                description: "Lesson ID",
                schema: new OA\Schema(
                    type: "integer",
                    example: 1
                )
            )
        ],

        responses: [

            new OA\Response(
                response: 200,
                description: "Lesson retrieved successfully"
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "Unauthorized action"
            ),

            new OA\Response(
                response: 404,
                description: "Lesson not found"
            )
        ]
    )]
    public function show(Lesson $lesson)
    {
        $this->authorize('view', $lesson);

        return response()->json([
            'data' => new LessonResource(
                $this->lessonService->show($lesson)
            ),
        ]);
    }

    #[OA\Put(
        path: "/api/lessons/{lesson}",
        summary: "Update a lesson",
        tags: ["Lessons"],

        security: [
            ["sanctum" => []]
        ],

        parameters: [
            new OA\Parameter(
                name: "lesson",
                in: "path",
                required: true,
                description: "Lesson ID",
                schema: new OA\Schema(
                    type: "integer",
                    example: 1
                )
            )
        ],

        requestBody: new OA\RequestBody(
            required: true,

            content: new OA\JsonContent(
                required: [
                    "title"
                ],

                properties: [

                    new OA\Property(
                        property: "title",
                        type: "string",
                        example: "Updated Laravel Container"
                    ),

                    new OA\Property(
                        property: "description",
                        type: "string",
                        nullable: true,
                        example: "Updated description"
                    ),

                    new OA\Property(
                        property: "video",
                        type: "string",
                        format: "binary",
                        nullable: true,
                        example: "https://example.com/video-updated.mp4"
                    ),

                    new OA\Property(
                        property: "order",
                        type: "integer",
                        nullable: true,
                        example: 2
                    ),

                    new OA\Property(
                        property: "is_free",
                        type: "boolean",
                        nullable: true,
                        example: true
                    ),

                    new OA\Property(
                        property: "duration",
                        type: "integer",
                        nullable: true,
                        example: 60
                    )
                ]
            )
        ),

        responses: [

            new OA\Response(
                response: 200,
                description: "Lesson updated successfully"
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "Unauthorized action"
            ),

            new OA\Response(
                response: 404,
                description: "Lesson not found"
            ),

            new OA\Response(
                response: 422,
                description: "Validation error"
            )
        ]
    )]
    public function update(LessonRequest $request, Lesson $lesson)
    {
        $this->authorize('update', $lesson);

        $lesson = $this->lessonService->update(
            $lesson,
            $request->validated()
        );

        return response()->json([
            'message' => 'Lesson updated successfully',
            'data' => new LessonResource($lesson),
        ]);
    }

    #[OA\Delete(
        path: "/api/lessons/{lesson}",
        summary: "Delete a lesson",
        tags: ["Lessons"],

        security: [
            ["sanctum" => []]
        ],

        parameters: [
            new OA\Parameter(
                name: "lesson",
                in: "path",
                required: true,
                description: "Lesson ID",
                schema: new OA\Schema(
                    type: "integer",
                    example: 1
                )
            )
        ],

        responses: [

            new OA\Response(
                response: 200,
                description: "Lesson deleted successfully"
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "Unauthorized action"
            ),

            new OA\Response(
                response: 404,
                description: "Lesson not found"
            )
        ]
    )]
    public function destroy(Lesson $lesson)
    {
        $this->authorize('delete', $lesson);

        $this->lessonService->delete($lesson);

        return response()->json([
            'message' => 'Lesson deleted successfully',
        ]);
    }

    #[OA\Post(
        path: "/api/lessons/{lesson}/complete",
        summary: "Mark lesson as completed",
        tags: ["Lesson Progress"],

        security: [
            ["sanctum" => []]
        ],

        parameters: [
            new OA\Parameter(
                name: "lesson",
                in: "path",
                required: true,
                description: "Lesson ID",
                schema: new OA\Schema(
                    type: "integer",
                    example: 1
                )
            )
        ],

        responses: [

            new OA\Response(
                response: 200,
                description: "Lesson completed successfully"
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 403,
                description: "Unauthorized action"
            )
        ]
    )]
    public function complete(Request $request, Lesson $lesson)
    {
        $this->authorize('view', $lesson);

        $progress = $this->lessonService->complete(
            $request->user(),
            $lesson
        );

        return response()->json([
            'message' => 'Lesson completed successfully',
            'data' => new LessonProgressResource($progress),
        ]);
    }
}