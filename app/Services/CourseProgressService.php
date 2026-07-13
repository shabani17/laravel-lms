<?php

namespace App\Services;

use App\DTOs\CourseProgressDTO;
use App\Models\Course;
use App\Models\User;

class CourseProgressService
{
    public function calculate(User $user, Course $course): CourseProgressDTO
    {
        $totalLessons = $course->lessons()->count();

        $completedLessons = $user->lessonProgress()
            ->whereHas('lesson', function ($query) use ($course) {
                $query->where('course_id', $course->id);
            })
            ->count();

        $percentage = $totalLessons > 0
            ? round(($completedLessons / $totalLessons) * 100, 2)
            : 0;

        return new CourseProgressDTO(
            totalLessons: $totalLessons,
            completedLessons: $completedLessons,
            percentage: $percentage
        );
    }
}