<?php

namespace App\Http\Controllers;


use App\Http\Requests\CourseListRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Mappers\CourseFilterMapper;
use App\Models\Course;
use App\Services\CourseService;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;


class CourseController extends Controller
{
    private CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }


    #[OA\Get(
        path: "/api/courses",
        summary: "Get list of courses",
        tags: ["Courses"],

        responses: [
                new OA\Response(
                    response: 200,
                    description: "List of courses",
                    content: new OA\JsonContent(
                        type: "array",
                        items: new OA\Items(
                            ref: "#/components/schemas/Course"
                        )
                    )
                )
        ]
    )]
    public function index(CourseListRequest $request)
    {
        $filters = CourseFilterMapper::fromRequest($request);

        $courses = $this->courseService->list($filters);

        return CourseResource::collection($courses);
        
    }

    public function store(StoreCourseRequest $request)
    {
        $course = $this->courseService->create(
            $request->validated(),
            $request->user()
        );

        return response()->json([
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);
    }


    #[OA\Get(
        path: "/api/courses/{course}",
        summary: "Get single course",
        tags: ["Courses"],
        security: [
            ["sanctum" => []]
        ],

        parameters: [
            new OA\Parameter(
                name: "course",
                description: "Course ID",
                in: "path",
                required: true,
                example: 1
            )
        ],

        responses: [
            new OA\Response(
                response: 200,
                description: "Course details",
                content: new OA\JsonContent(
                    ref: "#/components/schemas/Course"
                )
            ),

            new OA\Response(
                response: 404,
                description: "Course not found"
            )
        ]
    )]
    public function show(Course $course)
    {
        return new CourseResource($course->load('teacher'));
    }

    public function update(UpdateCourseRequest $request, Course $course)
    {
        $this->authorize('update', $course);

        $course = $this->courseService->update(
            $course,
            $request->validated()
        );

        return new CourseResource($course->load('teacher'));
    }

    public function destroy(Course $course)
    {
        $this->authorize('delete', $course);

        $this->courseService->delete($course);

        return response()->noContent();
    }

    public function teacherCourses(Request $request)
    {
        $courses = $this->courseService->teacherCourses($request->user());

        return response()->json([
            'data' => $courses,
        ]);
    }

    public function students(Course $course)
    {
        $this->authorize('viewStudents', $course);

        $students = $this->courseService->courseStudent($course);

        return response()->json([
            'data' => $students,
        ]);
    }
}