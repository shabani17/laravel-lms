<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            // student (user)
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // course
            $table->foreignId('course_id')
                ->constrained('courses')
                ->cascadeOnDelete();

            $table->string('status')->default('active');
            // active | completed | cancelled

            $table->timestamp('enrolled_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
