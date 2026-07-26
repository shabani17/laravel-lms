<?php

namespace App\Services;

use App\Events\StudentEnrolled;
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

        $enrollment = $this->enrollmentRepository->create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        StudentEnrolled::dispatch($user, $course, $enrollment);

        return $enrollment;
    }

    public function myCourses(User $user)
    {
        return $user->enrolledCourses()->get();
    }
}