<?php

namespace App\Repositories\Eloquent;

use App\Models\Lesson;
use App\Repositories\Contracts\LessonRepositoryInterface;

class EloquentLessonRepository implements LessonRepositoryInterface
{
    public function find(Lesson $lesson): Lesson
    {
        return $lesson;
    }

    public function create(array $data): Lesson
    {
        return Lesson::create($data);
    }

    public function update(Lesson $lesson, array $data): Lesson
    {
        $lesson->update($data);

        return $lesson;
    }

    public function delete(Lesson $lesson): void
    {
        $lesson->delete();
    }
}