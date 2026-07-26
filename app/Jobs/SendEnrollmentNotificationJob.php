<?php

namespace App\Jobs;

use App\Models\User;
use App\Models\Course;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendEnrollmentNotificationJob implements ShouldQueue
{
    use Queueable;

    public int $tries = 3;

    public int $timeout = 60;

    public function backoff(): array
    {
        return [10, 30, 60];
    }

    public function __construct(
        public User $user,
        public Course $course
    ) {}

    public function handle(): void
    {
        Log::info('Enrollment notification sent', [
            'student_id' => $this->user->id,
            'course_id' => $this->course->id,
        ]);
    }
}