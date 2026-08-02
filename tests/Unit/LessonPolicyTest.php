<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Policies\LessonPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LessonPolicyTest extends TestCase
{
    use RefreshDatabase;


    public function test_teacher_can_view_lesson(): void
    {
        $teacher = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
        ]);

        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        $policy = new LessonPolicy();

        $this->assertTrue(
            $policy->view($teacher, $lesson)
        );
    }


    public function test_student_can_view_lesson(): void
    {
        $teacher = User::factory()->create();
        $student = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
        ]);

        $course->students()->attach($student->id);

        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        $policy = new LessonPolicy();

        $this->assertTrue(
            $policy->view($student, $lesson)
        );
    }


    public function test_other_user_cannot_update_lesson(): void
    {
        $teacher = User::factory()->create();
        $otherUser = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
        ]);

        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        $policy = new LessonPolicy();

        $this->assertFalse(
            $policy->update($otherUser, $lesson)
        );
    }


    public function test_teacher_can_delete_lesson(): void
    {
        $teacher = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $teacher->id,
        ]);

        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        $policy = new LessonPolicy();

        $this->assertTrue(
            $policy->delete($teacher, $lesson)
        );
    }
}