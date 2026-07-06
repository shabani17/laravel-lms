<?php
namespace App\Services;

use App\Models\Course;
use App\Models\Lesson;

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
}