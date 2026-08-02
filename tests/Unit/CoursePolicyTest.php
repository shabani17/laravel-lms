<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Policies\CoursePolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoursePolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_update_own_course(): void
    {
        $teacher = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
        ]);

        $policy = new CoursePolicy();

        $this->assertTrue(
            $policy->update($teacher, $course)
        );
    }


    public function test_other_user_cannot_update_course(): void
    {
        $teacher = User::factory()->create();

        $otherUser = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
        ]);

        $policy = new CoursePolicy();

        $this->assertFalse(
            $policy->update($otherUser, $course)
        );
    }


    public function test_student_can_view_enrolled_course(): void
    {
        $teacher = User::factory()->create();
        $student = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
        ]);

        $course->students()->attach($student->id);

        $policy = new CoursePolicy();

        $this->assertTrue(
            $policy->view($student, $course)
        );
    }


    public function test_student_can_view_progress(): void
    {
        $teacher = User::factory()->create();
        $student = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
        ]);

        $course->students()->attach($student->id);

        $policy = new CoursePolicy();

        $this->assertTrue(
            $policy->viewProgress($student, $course)
        );
    }
}