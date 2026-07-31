<?php

namespace Tests\Feature;

use App\Events\StudentEnrolled;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_can_enroll_in_course(): void
    {
        Event::fake();

        $teacher = User::factory()->create([
            'role' => 'teacher',
        ]);

        $student = User::factory()->create([
            'role' => 'student',
        ]);

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
        ]);

        Sanctum::actingAs($student);

        $response = $this->postJson("/api/courses/{$course->id}/enroll");

        $response->assertCreated();

        $this->assertDatabaseHas('enrollments', [
            'user_id' => $student->id,
            'course_id' => $course->id,
        ]);

        Event::assertDispatched(StudentEnrolled::class);
    }
}