<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_create_course()
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->postJson('/api/courses', [
                'title' => 'Laravel Advanced Course',
                'slug' => 'laravel-advanced-course',
                'description' => 'Learn Laravel',
                'price' => 100,
                'level' => 'advanced',
                'status' => 'published',
            ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('courses', [
            'slug' => 'laravel-advanced-course',
        ]);
    }

    public function test_user_can_see_courses()
{
    $user = User::factory()->create();

    Course::factory()->create([
        'title' => 'Laravel Course',
    ]);

    $response = $this
        ->actingAs($user)
        ->getJson('/api/courses');

    $response->assertOk();

    $response->assertJsonFragment([
        'title' => 'Laravel Course',
    ]);
}

public function test_teacher_can_update_course()
{
    $user = User::factory()->create();

    $course = Course::factory()->create([
        'teacher_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->putJson("/api/courses/{$course->id}", [
            'title' => 'Updated Course',
            'slug' => 'updated-course',
            'price' => 200,
            'level' => 'advanced',
            'status' => 'published',
        ]);

    $response->assertOk();

    $this->assertDatabaseHas('courses', [
        'title' => 'Updated Course',
    ]);
}

public function test_teacher_can_delete_course()
{
    $user = User::factory()->create();

    $course = Course::factory()->create([
        'teacher_id' => $user->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->deleteJson("/api/courses/{$course->id}");

    $response->assertNoContent();

    $this->assertDatabaseMissing('courses', [
        'id' => $course->id,
    ]);
}

public function test_course_creation_requires_title(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
        ]);

        $token = $teacher->createToken('test')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson('/api/courses', [
                'description' => 'Test Description',
            ]);

        $response
            ->assertStatus(422)
            ->assertJsonValidationErrors(['title']);
    }
}