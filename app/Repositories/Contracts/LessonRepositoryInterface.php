<?php

namespace App\Repositories\Contracts;

use App\Models\Lesson;

interface LessonRepositoryInterface
{
    public function find(Lesson $lesson): Lesson;

    public function create(array $data): Lesson;

    public function update(Lesson $lesson, array $data): Lesson;

    public function delete(Lesson $lesson): void;
}