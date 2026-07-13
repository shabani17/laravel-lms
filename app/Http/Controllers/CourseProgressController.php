<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseProgressResource;
use App\Models\Course;
use App\Services\CourseProgressService;
use Illuminate\Http\Request;

class CourseProgressController extends Controller
{
    public function __construct(
        private CourseProgressService $progressService
    ) {
    }

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