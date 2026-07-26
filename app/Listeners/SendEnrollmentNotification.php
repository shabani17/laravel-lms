<?php

namespace App\Listeners;

use App\Events\StudentEnrolled;
use App\Jobs\SendEnrollmentNotificationJob;

class SendEnrollmentNotification
{
    public function handle(StudentEnrolled $event): void
    {
        SendEnrollmentNotificationJob::dispatch(
            $event->user,
            $event->course
        );
    }
}