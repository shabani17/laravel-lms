<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_create_lesson()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson("/api/courses/{$course->id}/lessons", [
                'title' => 'Laravel Events',
                'description' => 'Learn Laravel Events',
                'video_url' => 'https://example.com/video.mp4',
                'order' => 1,
                'is_free' => false,
                'duration' => 60,
            ]);

        $response->assertCreated();

        $this->assertDatabaseHas('lessons', [
            'title' => 'Laravel Events',
            'course_id' => $course->id,
        ]);
    }


    public function test_user_can_see_course_lessons()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        Lesson::factory()->create([
            'course_id' => $course->id,
            'title' => 'Introduction',
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson("/api/courses/{$course->id}/lessons");

        $response->assertOk();

        $response->assertJsonFragment([
            'title' => 'Introduction',
        ]);
    }

    public function test_user_can_complete_lesson()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->postJson("/api/lessons/{$lesson->id}/complete");

        $response->assertOk();

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
        ]);
    }

    public function test_guest_cannot_create_lesson()
    {
        $course = Course::factory()->create();

        $response = $this
            ->postJson("/api/courses/{$course->id}/lessons", [
                'title' => 'Test Lesson',
                'duration' => 30,
            ]);

        $response->assertUnauthorized();
    }

}