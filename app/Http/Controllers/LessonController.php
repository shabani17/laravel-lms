<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\LessonService;



class LessonController extends Controller
{
    public function __construct(
        protected LessonService $lessonService
    ) {}

    public function index(Course $course)
    {

        $this->authorize('viewLessons', $course);

        return response()->json([
            'data' => LessonResource::collection($this->lessonService->list($course)),
        ]);
    }

    public function store(LessonRequest $request, Course $course)
    {
        $this->authorize('manageLessons', $course);
        

        $lesson = $this->lessonService->create($course, $request->validated());

        return response()->json([
            'message' => 'Lesson created successfully',
            'data' => new LessonResource($lesson),
        ],201);
    }

    public function show(Lesson $lesson)
    {
        $this->authorize('view', $lesson);

        return response()->json([
            'data' => new LessonResource($this->lessonService->show($lesson)),
        ]);
    }
}
