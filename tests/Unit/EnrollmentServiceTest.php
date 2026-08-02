<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use App\Repositories\Contracts\EnrollmentRepositoryInterface;
use App\Services\EnrollmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Mockery;
use Tests\TestCase;

class EnrollmentServiceTest extends TestCase
{
    use RefreshDatabase;
    public function test_user_can_enroll_in_course()
    {
        Event::fake();

        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $repository = Mockery::mock(EnrollmentRepositoryInterface::class);

        $repository
            ->shouldReceive('exists')
            ->with($user, $course)
            ->once()
            ->andReturn(false);

        $enrollment = new Enrollment([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'status' => 'active',
        ]);

        $repository
            ->shouldReceive('create')
            ->once()
            ->andReturn($enrollment);

        $service = new EnrollmentService($repository);

        $result = $service->enroll($user, $course);

        $this->assertEquals($user->id, $result->user_id);
        $this->assertEquals($course->id, $result->course_id);
    }

    public function test_user_cannot_enroll_twice_in_same_course()
    {
        Event::fake();

        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $repository = Mockery::mock(EnrollmentRepositoryInterface::class);

        $repository
            ->shouldReceive('exists')
            ->with($user, $course)
            ->once()
            ->andReturn(true);


        $repository
            ->shouldNotReceive('create');


        $service = new EnrollmentService($repository);


        $this->expectException(\Exception::class);

        $this->expectExceptionMessage(
            'User already enrolled in this course'
        );


        $service->enroll(
            $user,
            $course
        );
    }

    public function test_user_can_get_enrolled_courses()
    {
        $user = User::factory()->create();

        $course = Course::factory()->create([
            'teacher_id' => $user->id,
        ]);

        $user->enrolledCourses()->attach($course->id, [
            'status' => 'active',
            'enrolled_at' => now(),
        ]);

        $service = new EnrollmentService(
            Mockery::mock(EnrollmentRepositoryInterface::class)
        );

        $courses = $service->myCourses($user);

        $this->assertCount(1, $courses);

        $this->assertEquals(
            $course->id,
            $courses->first()->id
        );
    }
}