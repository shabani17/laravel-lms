<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseProgressController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\LessonController;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return response()->json([
        'message' => 'API working'
    ]);
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);


    // Courses
    Route::apiResource('courses', CourseController::class);

    Route::get('/teacher/courses', [CourseController::class, 'teacherCourses']);


    // Enrollment
    Route::post('/courses/{course}/enroll', [EnrollmentController::class, 'enroll']);

    Route::get('/my-courses', [EnrollmentController::class, 'myCourses']);


    // Lessons of course
    Route::get(
        '/courses/{course}/lessons',
        [LessonController::class, 'index']
    );

    Route::post(
        '/courses/{course}/lessons',
        [LessonController::class, 'store']
    );


    // Lesson CRUD
    Route::get(
        '/lessons/{lesson}',
        [LessonController::class, 'show']
    );

    Route::put(
        '/lessons/{lesson}',
        [LessonController::class, 'update']
    );

    Route::delete(
        '/lessons/{lesson}',
        [LessonController::class, 'destroy']
    );


    // Lesson Progress
    Route::post(
        '/lessons/{lesson}/complete',
        [LessonController::class, 'complete']
    );


    // Course Progress
    Route::get(
        '/courses/{course}/progress',
        [CourseProgressController::class, 'show']
    );

});