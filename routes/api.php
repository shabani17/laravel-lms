<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json([
        'message' => 'API working'
    ]);
});

Route::post('/register', [AuthController::class , 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('courses', CourseController::class);
});