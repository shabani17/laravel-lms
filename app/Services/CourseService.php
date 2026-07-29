<?php

namespace App\Services;

use App\DTOs\CourseFilterDTO;
use App\Models\Course;
use App\Models\User;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Support\CacheKeys;
use Illuminate\Support\Facades\Cache;

class CourseService
{
    private CourseRepositoryInterface $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository;
    }

    public function create(array $data, User $user): Course
    {
        $course = $this->courseRepository->create([
            ...$data,
            'teacher_id' => $user->id,
        ]);
        Cache::forget(CacheKeys::COURSES_LIST);
        return $course;
    }

    public function update(Course $course, array $data): Course
    {
        $course =$this->courseRepository->update($course, $data);
        Cache::forget(CacheKeys::COURSES_LIST);
        return $course;

    }

    public function delete(Course $course): void
    {
        $this->courseRepository->delete($course);
        Cache::forget(CacheKeys::COURSES_LIST);

    }

    public function teacherCourses(User $user)
    {
        return $user->courses()->latest()->get();
    }

    public function courseStudent(Course $course)
    {
        return $course->students()->get();
    }

    public function list(CourseFilterDTO $filters)
    {

        return Cache::remember(
            CacheKeys::COURSES_LIST,
            now()->addMinutes(30),
            fn () => $this->courseRepository->list($filters)
        );
    }
}