<?php

namespace App\Http\Controllers;

use App\Http\Requests\DeleteCourseRequest;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;
use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses= Course::with('teacher')->get();

        return CourseResource::collection($courses);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request)
    {
        $data = $request->validated();

        $course = Course::create([
            ...$data,
            'teacher_id' => $request->user()->id,
        ]);

        return response()->json([
            'message' => 'Course created successfully',
            'data' => $course
        ], 201);

        
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        return new CourseResource($course->load('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course)
    {
        $course->update($request->validated());

        return new CourseResource($course->load('teacher'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DeleteCourseRequest $request, Course $course)
    {
        $course->delete();

        return response()->noContent();
    }
}
