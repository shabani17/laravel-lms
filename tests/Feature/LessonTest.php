<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use App\Models\Lesson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LessonTest extends TestCase
    {
        use RefreshDatabase;

        public function test_teacher_can_create_lesson()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $video = UploadedFile::fake()->create(
            'lesson.mp4',
            1024,
            'video/mp4'
        );

        $response = $this
            ->actingAs($user)
            ->postJson("/api/courses/{$course->id}/lessons", [
                'title' => 'Laravel Events',
                'description' => 'Learn Laravel Events',
                'video' => $video,
                'order' => 1,
                'is_free' => false,
                'duration' => 60,
            ]);

        $response->assertCreated();

        $lesson = Lesson::where(
            'title',
            'Laravel Events'
        )->first();

        Storage::disk('public')
            ->assertExists($lesson->video_url);

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

    public function test_teacher_can_update_lesson_video()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
            'video_url' => 'lessons/videos/old.mp4',
        ]);

        Storage::disk('public')->put(
            'lessons/videos/old.mp4',
            'old video'
        );

        $video = UploadedFile::fake()->create(
            'new.mp4',
            1024,
            'video/mp4'
        );

        $response = $this
            ->actingAs($user)
            ->putJson("/api/lessons/{$lesson->id}", [
                'title' => 'Updated Lesson',
                'video' => $video,
                'order' => 1,
                'is_free' => false,
                'duration' => 90,
            ]);

        $response->assertOk();

        $lesson->refresh();

        Storage::disk('public')
            ->assertExists($lesson->video_url);

        Storage::disk('public')
            ->assertMissing('lessons/videos/old.mp4');
    }

}