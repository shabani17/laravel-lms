<?php

namespace Tests\Feature;

use App\Events\StudentEnrolled;
use App\Listeners\SendEnrollmentNotification;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Notifications\EnrollmentNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendEnrollmentNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_listener_sends_enrollment_notification(): void
    {
        Notification::fake();

        $student = User::factory()->create([
            'role' => 'student',
        ]);

        $course = Course::factory()->create();

        $enrollment = Enrollment::create([
            'user_id' => $student->id,
            'course_id' => $course->id,
            'status' => 'active',
        ]);

        $event = new StudentEnrolled(
            $student,
            $course,
            $enrollment
        );

        $listener = new SendEnrollmentNotification();

        $listener->handle($event);

        Notification::assertSentTo(
            $student,
            EnrollmentNotification::class
        );
    }
}