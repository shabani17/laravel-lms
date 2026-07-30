<?php

namespace App\Listeners;

use App\Events\StudentEnrolled;
use App\Notifications\EnrollmentNotification;

class SendEnrollmentNotification
{
    public function handle(StudentEnrolled $event): void
    {
        $event->user->notify(new EnrollmentNotification($event->course));
    }
}