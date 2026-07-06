<?php

namespace App\Models;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Model;

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
    
public function teacher(){
    return $this->belongsTo(User::class, 'teacher_id');
}

public function students()
{
    return $this->belongsToMany(User::class,'enrollments','course_id','user_id')
    ->withPivot('status', 'enrolled_at')->withTimestamps();
}

public function enrollments()
{
    return $this->hasMany(Enrollment::class);
}

public function lessons()
{
    return $this->hasMany(Lesson::class);
}

}
