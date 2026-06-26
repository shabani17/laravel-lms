<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Services\EnrollmentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class EnrollmentController extends Controller
{
    public function __construct(protected EnrollmentService $enrollmentService)
    {
        //
    }

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

    public function myCourses(Request $request)
    {
        $courses = $this->enrollmentService->myCourses($request->user());

        return response()->json([
            'data'=> $courses ,
        ]);
    }
}
