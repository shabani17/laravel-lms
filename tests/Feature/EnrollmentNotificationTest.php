<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use App\Notifications\EnrollmentNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class EnrollmentNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_receive_enrollment_notification(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'role' => 'student',
        ]);

        $course = Course::factory()->create();

        $user->notify(new EnrollmentNotification($course));

        Notification::assertSentTo(
            $user,
            EnrollmentNotification::class
        );
    }
}