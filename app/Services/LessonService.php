<?php
namespace App\Services;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;

class LessonService
{
    public function create(Course $course, array $data)
    {
        return $course->lessons()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'video_url' => $data['video_url'] ?? null,
            'order' => $data['order'] ?? 1,
            'is_free' => $data['is_free'] ?? false,
            'duration' => $data['duration'] ?? null,
        ]);
    }

    public function list(Course $course)
    {
        return $course->lessons()->orderBy('order')->get();
    }

    public function show(Lesson $lesson): Lesson
    {
        return $lesson;
    }

    public function complete(User $user, Lesson $lesson): LessonProgress
    {
        return LessonProgress::firstOrCreate(
            [
                'user_id' => $user->id ,
                'lesson_id' => $lesson->id ,
            ],
            [
                'completed_at'=> now(),
            ]
        );
    }
}