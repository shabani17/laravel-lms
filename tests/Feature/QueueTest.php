<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use App\Notifications\EnrollmentNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Notifications\SendQueuedNotifications;
use Tests\TestCase;

class QueueTest extends TestCase
{
    use RefreshDatabase;

    public function test_enrollment_notification_is_queued(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'role' => 'student',
        ]);

        $course = Course::factory()->create();

        $user->notify(new EnrollmentNotification($course));

        Queue::assertPushed(SendQueuedNotifications::class);
    }
}