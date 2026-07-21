<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use App\Models\User;
use App\Repositories\Contracts\LessonRepositoryInterface;

class LessonService
{
    public function __construct(
        private LessonRepositoryInterface $lessonRepository
    ) {}

    public function create(Course $course, array $data): Lesson
    {
        return $this->lessonRepository->create([
            ...$data,
            'course_id' => $course->id,
        ]);
    }

    public function list(Course $course)
    {
        return $course->lessons;
    }

    public function show(Lesson $lesson): Lesson
    {
        return $this->lessonRepository->find($lesson);
    }

    public function update(Lesson $lesson, array $data): Lesson
    {
        return $this->lessonRepository->update($lesson, $data);
    }

    public function delete(Lesson $lesson): void
    {
        $this->lessonRepository->delete($lesson);
    }

    public function complete(User $user, Lesson $lesson): LessonProgress
    {
        return LessonProgress::firstOrCreate(
            [
                'user_id' => $user->id,
                'lesson_id' => $lesson->id,
            ],
            [
                'completed_at' => now(),
            ]
        );
    }
}