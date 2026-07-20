<?php

namespace App\Repositories\Eloquent;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Repositories\Contracts\EnrollmentRepositoryInterface;

class EloquentEnrollmentRepository implements EnrollmentRepositoryInterface
{
    public function create(array $data): Enrollment
    {
        return Enrollment::create($data);
    }

    public function exists(User $user, Course $course): bool
    {
        return Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->exists();
    }
}