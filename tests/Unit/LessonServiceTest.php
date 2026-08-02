<?php

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Repositories\Contracts\LessonRepositoryInterface;
use App\Services\LessonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class LessonServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_lesson()
    {
        $course = Course::factory()->create();

        $data = [
            'title' => 'Lesson 1',
            'description' => 'Test lesson',
            'video_url' => 'https://example.com/video.mp4',
            'order' => 1,
            'is_free' => true,
            'duration' => 300,
        ];

        $repository = Mockery::mock(LessonRepositoryInterface::class);

        $lesson = new Lesson([
            ...$data,
            'course_id' => $course->id,
        ]);

        $repository
            ->shouldReceive('create')
            ->once()
            ->andReturn($lesson);

        $service = new LessonService($repository);

        $result = $service->create($course, $data);

        $this->assertEquals($course->id, $result->course_id);
        $this->assertEquals('Lesson 1', $result->title);
    }

    public function test_can_show_lesson()
    {
        $lesson = Lesson::factory()->create();

        $repository = Mockery::mock(LessonRepositoryInterface::class);

        $repository
            ->shouldReceive('find')
            ->once()
            ->with($lesson)
            ->andReturn($lesson);

        $service = new LessonService($repository);

        $result = $service->show($lesson);

        $this->assertEquals($lesson->id, $result->id);
        $this->assertEquals($lesson->title, $result->title);
    }

    public function test_can_update_lesson()
    {
        $lesson = Lesson::factory()->create();

        $data = [
            'title' => 'Updated Lesson',
            'description' => 'Updated description',
        ];

        $updatedLesson = new Lesson([
            ...$lesson->toArray(),
            ...$data,
        ]);

        $repository = Mockery::mock(LessonRepositoryInterface::class);

        $repository
            ->shouldReceive('update')
            ->once()
            ->with($lesson, $data)
            ->andReturn($updatedLesson);

        $service = new LessonService($repository);

        $result = $service->update($lesson, $data);

        $this->assertEquals('Updated Lesson', $result->title);
        $this->assertEquals('Updated description', $result->description);
    }

    public function test_can_delete_lesson()
    {
        $lesson = Lesson::factory()->create();

        $repository = Mockery::mock(LessonRepositoryInterface::class);

        $repository
            ->shouldReceive('delete')
            ->once()
            ->with($lesson);

        $service = new LessonService($repository);

        $service->delete($lesson);

        $this->assertTrue(true);
    }

    public function test_can_list_course_lessons()
    {
        $course = Course::factory()->create();

                Lesson::factory()->create([
            'course_id' => $course->id,
            'order' => 1,
        ]);

        Lesson::factory()->create([
            'course_id' => $course->id,
            'order' => 2,
        ]);

        Lesson::factory()->create([
            'course_id' => $course->id,
            'order' => 3,
        ]);

        $repository = Mockery::mock(LessonRepositoryInterface::class);

        $service = new LessonService($repository);

        $lessons = $service->list($course);

        $this->assertCount(3, $lessons);
    }

    public function test_user_can_complete_lesson()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create();

        $lesson = Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        $repository = Mockery::mock(LessonRepositoryInterface::class);

        $service = new LessonService($repository);

        $progress = $service->complete($user, $lesson);

        $this->assertDatabaseHas('lesson_progress', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
        ]);

        $this->assertEquals($lesson->id, $progress->lesson_id);
    }
   
}