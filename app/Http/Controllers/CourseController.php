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


class CourseController extends Controller
{
    private CourseService $courseService;

    public function __construct(CourseService $courseService)
    {
        $this->courseService = $courseService;
    }

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