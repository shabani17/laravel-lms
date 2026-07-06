<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Models\Course;
use App\Services\LessonService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LessonController extends Controller
{
    public function __construct(
        protected LessonService $lessonService
    ) {}

    public function index(Course $course)
    {
        return response()->json([
            'data' => $this->lessonService->list($course)
        ]);
    }

    public function store(LessonRequest $request, Course $course)
    {
        $this->authorize('manageLessons', $course);
        

        $lesson = $this->lessonService->create($course, $request->validated());

        return response()->json([
            'message' => 'Lesson created successfully',
            'data' => $lesson
        ]);
    }
}
