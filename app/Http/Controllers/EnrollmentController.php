<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use OpenApi\Attributes as OA;


class EnrollmentController extends Controller
{
    public function __construct(protected EnrollmentService $enrollmentService)
    {
        //
    }

    #[OA\Post(
        path: "/api/courses/{course}/enroll",
        summary: "Enroll in a course",
        tags: ["Enrollment"],

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
                response: 201,
                description: "Enrolled successfully"
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            ),

            new OA\Response(
                response: 409,
                description: "Already enrolled or conflict"
            )
        ]
    )]
    public function enroll(Request $request, Course $course)
    {
        Gate::authorize('enroll', \App\Models\Enrollment::class);

        try{
            $enrollment = $this->enrollmentService->enroll($request->user(), $course);

        return response()->json([
            'message' => 'Enrolled successfully',
            'data' => $enrollment,
        ], 201);

        } catch(\Exception $e){
            
            return response()->json([
                'message' => $e->getMessage(),
            ],409);
        }
    }

    #[OA\Get(
        path: "/api/my-courses",
        summary: "Get authenticated user's courses",
        tags: ["Enrollment"],

        security: [
            ["sanctum" => []]
        ],

        responses: [

            new OA\Response(
                response: 200,
                description: "List of enrolled courses"
            ),

            new OA\Response(
                response: 401,
                description: "Unauthenticated"
            )
        ]
    )]
    public function myCourses(Request $request)
    {
        $courses = $this->enrollmentService->myCourses($request->user());

        return response()->json([
            'data'=> $courses ,
        ]);
    }
}
