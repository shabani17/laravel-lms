<?php

namespace App\Notifications;

use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class EnrollmentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Course $course
    ) {
    }

    public function via(object $notifiable): array
    {
        return [
            'database',
            'mail',
        ];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'message' => "You enrolled in {$this->course->title}",
            'course_id' => $this->course->id,
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Course Enrollment Confirmation')
            ->line("You successfully enrolled in {$this->course->title}")
            ->line('Thank you for joining our LMS.');
    }
}