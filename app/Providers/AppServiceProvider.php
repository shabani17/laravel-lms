<?php

namespace App\Providers;

use App\Models\Enrollment;
use App\Policies\EnrollmentPolicy;
use App\Repositories\Contracts\CourseRepositoryInterface;
use App\Repositories\Contracts\EnrollmentRepositoryInterface;
use App\Repositories\Contracts\LessonRepositoryInterface;
use App\Repositories\Eloquent\EloquentCourseRepository;
use App\Repositories\Eloquent\EloquentEnrollmentRepository;
use App\Repositories\Eloquent\EloquentLessonRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            CourseRepositoryInterface::class,
            EloquentCourseRepository::class
        );

        $this->app->bind(
            EnrollmentRepositoryInterface::class,
            EloquentEnrollmentRepository::class
        );
        $this->app->bind(
            LessonRepositoryInterface::class,
            EloquentLessonRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(
            Enrollment::class,
            EnrollmentPolicy::class
        );
    }
}