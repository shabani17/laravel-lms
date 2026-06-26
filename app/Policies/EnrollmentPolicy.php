<?php

namespace App\Policies;

use App\Models\User;

class EnrollmentPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function enroll(User $user): bool
    {
        return $user->role === 'student';
    }
}
