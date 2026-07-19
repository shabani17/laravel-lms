<?php

namespace App\Services;

use App\DTOs\CourseFilterDTO;
use App\Models\User;
use App\Repositories\Contracts\CourseRepositoryInterface;

class CourseService
{

    private CourseRepositoryInterface $courseRepository;

    public function __construct(CourseRepositoryInterface $courseRepository)
    {
        $this->courseRepository = $courseRepository ;
    }

    public function create(array $data, User $user)
    {
        return $this->courseRepository->create([
            ...$data,
            'teacher_id' => $user->id,
        ]);
    }

    public function update(Course $course, array $data)
    {
        return $this->courseRepository->update($course, $data);
    }

    public function delete(Course $course): void
    {
        $this->courseRepository->delete($course);
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
        return $this->courseRepository->list($filters);
    }
}