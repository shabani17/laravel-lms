<?php

namespace App\Events;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StudentEnrolled
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public User $user,
        public Course $course,
        public Enrollment $enrollment,
    ) {
    }
}