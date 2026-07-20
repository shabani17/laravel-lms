<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use App\Repositories\Contracts\EnrollmentRepositoryInterface;

class EnrollmentService
{
    private EnrollmentRepositoryInterface $enrollmentRepository;

    public function __construct(
        EnrollmentRepositoryInterface $enrollmentRepository
    ) {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function enroll(User $user, Course $course)
    {
        if ($this->enrollmentRepository->exists($user, $course)) {
            throw new \Exception('User already enrolled in this course');
        }

        return $this->enrollmentRepository->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);
    }

    public function myCourses(User $user)
    {
        return $user->enrollments()
            ->with('course')
            ->get()
            ->pluck('course');
    }
}