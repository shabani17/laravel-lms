<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;

class LessonPolicy
{
   
    public function view(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->course->teacher_id
            || $lesson->course->students()
                ->where('users.id', $user->id)
                ->exists();
    }

    
    public function update(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->course->teacher_id;
    }

    
    public function delete(User $user, Lesson $lesson): bool
    {
        return $user->id === $lesson->course->teacher_id;
    }
}