<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Policies\EnrollmentPolicy;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EnrollmentPolicyTest extends TestCase
{
    use RefreshDatabase;


    public function test_student_can_enroll(): void
    {
        $student = User::factory()->create([
            'role' => 'student',
        ]);

        $policy = new EnrollmentPolicy();

        $this->assertTrue(
            $policy->enroll($student)
        );
    }


    public function test_teacher_cannot_enroll(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
        ]);

        $policy = new EnrollmentPolicy();

        $this->assertFalse(
            $policy->enroll($teacher)
        );
    }


    public function test_admin_cannot_enroll(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $policy = new EnrollmentPolicy();

        $this->assertFalse(
            $policy->enroll($admin)
        );
    }
}