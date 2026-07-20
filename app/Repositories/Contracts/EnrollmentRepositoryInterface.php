<?php

namespace App\Repositories\Contracts;

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;

interface EnrollmentRepositoryInterface
{
    public function create(array $data): Enrollment;

    public function exists(User $user, Course $course): bool;
}