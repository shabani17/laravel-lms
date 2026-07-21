<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function view(User $user, Course $course): bool
    {
        return $user->id === $course->teacher_id
            || $course->students()
                ->where('users.id', $user->id)
                ->exists();
    }

    public function update(User $user, Course $course): bool
    {
        return $user->id === $course->teacher_id;
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->id === $course->teacher_id;
    }

    public function createLesson(User $user, Course $course): bool
    {
        return $user->id === $course->teacher_id;
    }

    public function viewStudents(User $user, Course $course): bool
    {
        return $user->id === $course->teacher_id;
    }

    public function viewProgress(User $user, Course $course): bool
    {
        return $user->id === $course->teacher_id
            || $course->students()
                ->where('users.id', $user->id)
                ->exists();
    }
}