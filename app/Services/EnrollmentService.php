<?php

namespace App\Services;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;

class EnrollmentService
{
    public function enroll(User $user, Course $course)
    {

        $exists = Enrollment::where('user_id' , $user->id)->where('course_id', $course->id)->exists();

        if($exists){
            throw new \Exception('User already enrolled in this course');
        }

        return Enrollment::create([
            'user_id' => $user->id ,
            'course_id' => $course->id ,
            'status' => 'active' ,
            'enrolled_at' => now() ,
        ]);
    }

    public function myCourses(User $user)
    {
        return $user->enrollments()->with('course')->get()->pluck('course');
    }
}