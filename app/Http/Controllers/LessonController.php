<?php

namespace App\Http\Controllers;

use App\Http\Requests\LessonRequest;
use App\Http\Resources\LessonProgressResource;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Services\LessonService;
use Illuminate\Http\Request;

class LessonController extends Controller
{
    public function __construct(
        protected LessonService $lessonService
    ) {}

    public function index(Course $course)
    {
        $this->authorize('view', $course);

        return response()->json([
            'data' => LessonResource::collection(
                $this->lessonService->list($course)
            ),
        ]);
    }

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

    public function show(Lesson $lesson)
    {
        $this->authorize('view', $lesson);

        return response()->json([
            'data' => new LessonResource(
                $this->lessonService->show($lesson)
            ),
        ]);
    }

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

    public function destroy(Lesson $lesson)
    {
        $this->authorize('delete', $lesson);

        $this->lessonService->delete($lesson);

        return response()->json([
            'message' => 'Lesson deleted successfully',
        ]);
    }

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