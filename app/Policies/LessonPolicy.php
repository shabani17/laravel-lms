<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }
    public function manage(User $user, Course $course):bool
    {
        return $user->id === $course->teacher_id;
    }


    public function view(User $user , Lesson $lesson): bool
    {
        return $user->id === $lesson->course->teacher_id ||
        $lesson->course->students()->where('users.id', $user->id)-> exists();
    }
}
