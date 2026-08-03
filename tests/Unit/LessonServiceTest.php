<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
use App\Models\LessonProgress;
use App\Repositories\Contracts\LessonRepositoryInterface;
use App\Services\FileUploadService;
use App\Services\LessonService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class LessonServiceTest extends TestCase
{
    use RefreshDatabase;

    private LessonService $service;
    private $repository;
    private $fileUploadService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(
            LessonRepositoryInterface::class
        );

        $this->fileUploadService = Mockery::mock(
            FileUploadService::class
        );

        $this->service = new LessonService(
            $this->repository,
            $this->fileUploadService
        );
    }


    public function test_can_create_lesson()
    {
        $course = Course::factory()->create();

        $lesson = Lesson::factory()->make([
            'course_id' => $course->id,
        ]);

        $this->repository
            ->shouldReceive('create')
            ->once()
            ->andReturn($lesson);

        $result = $this->service->create(
            $course,
            [
                'title' => 'Laravel Events',
            ]
        );

        $this->assertInstanceOf(
            Lesson::class,
            $result
        );
    }


    public function test_can_show_lesson()
    {
        $lesson = Lesson::factory()->create();

        $this->repository
            ->shouldReceive('find')
            ->once()
            ->with($lesson)
            ->andReturn($lesson);

        $result = $this->service->show($lesson);

        $this->assertEquals(
            $lesson,
            $result
        );
    }


    public function test_can_update_lesson()
    {
        $lesson = Lesson::factory()->create();

        $this->repository
            ->shouldReceive('update')
            ->once()
            ->andReturn($lesson);

        $result = $this->service->update(
            $lesson,
            [
                'title' => 'Updated Lesson',
            ]
        );

        $this->assertInstanceOf(
            Lesson::class,
            $result
        );
    }


    public function test_can_delete_lesson()
    {
        $lesson = Lesson::factory()->create();

        $this->repository
            ->shouldReceive('delete')
            ->once()
            ->with($lesson);

        $this->service->delete($lesson);

        $this->assertTrue(true);
    }


    public function test_can_list_course_lessons()
    {
        $course = Course::factory()->create();

        Lesson::factory()->create([
            'course_id' => $course->id,
        ]);

        $result = $this->service->list($course);

        $this->assertNotNull($result);
    }


    public function test_user_can_complete_lesson()
    {
        $user = User::factory()->create();

        $lesson = Lesson::factory()->create();

        $result = $this->service->complete(
            $user,
            $lesson
        );

        $this->assertInstanceOf(
            LessonProgress::class,
            $result
        );
    }


    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}