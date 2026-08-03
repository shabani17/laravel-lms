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

    public function __construct(CourseRepositoryInterface $courseRepository, private FileUploadService $fileUploadService)
    {
        $this->courseRepository = $courseRepository;
    }

    
    public function create(array $data, User $user): Course
    {
        if (isset($data['thumbnail'])) {
            $data['thumbnail'] = $this->fileUploadService
                ->uploadImage(
                    $data['thumbnail'],
                    'courses/thumbnails'
                );
        }

        $course = $this->courseRepository->create([
            ...$data,
            'teacher_id' => $user->id,
        ]);
            Cache::forget(CacheKeys::COURSES_LIST);
            return $course;
    }

    public function update(Course $course, array $data): Course
    {
    if (isset($data['thumbnail'])) {

        $this->fileUploadService->delete(
            $course->thumbnail
        );

        $data['thumbnail'] = $this->fileUploadService->uploadImage(
            $data['thumbnail'],
            'courses/thumbnails'
        );
    }

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
            CacheKeys::courses($filters),
            now()->addMinutes(30),
            fn () => $this->courseRepository->list($filters)
        );
    }
}