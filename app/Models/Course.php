<?php

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
use HasFactory;
protected $fillable = [
    'title',
    'slug',
    'description',
    'price',
    'level',
    'status',
    'teacher_id',
];
    
public function teacher(): BelongsTo
{
    return $this->belongsTo(User::class, 'teacher_id');
}

public function students(): BelongsToMany
{
    return $this->belongsToMany(User::class,'enrollments','course_id','user_id')->withTimestamps()
    ->withPivot('status', 'enrolled_at');
}

public function enrollments(): HasMany
{
    return $this->hasMany(Enrollment::class);
}

public function lessons(): HasMany
{
    return $this->hasMany(Lesson::class)->orderBy('order');
}

}
