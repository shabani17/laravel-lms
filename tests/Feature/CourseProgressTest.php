<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonProgress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseProgressTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_see_course_progress()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $lesson1 = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        $lesson2 = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        LessonProgress::create([
            'user_id' => $user->id,
            'lesson_id' => $lesson1->id,
            'completed_at' => now(),
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson("/api/courses/{$course->id}/progress");

        $response->assertOk();

        $response->assertJsonFragment([
            'total_lessons' => 2,
            'completed_lessons' => 1,
            'progress_percentage' => 50,
        ]);
    }
}