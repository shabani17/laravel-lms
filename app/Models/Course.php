<?php

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{

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
    return $this->belongsToMany(User::class,'enrollments','course_id','user_id')
    ->withPivot('status', 'enrolled_at')->withTimestamps();
}

public function enrollments(): HasMany
{
    return $this->hasMany(Enrollment::class);
}

public function lessons(): HasMany
{
    return $this->hasMany(Lesson::class);
}

}
