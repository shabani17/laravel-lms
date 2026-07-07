<?php

namespace App\Models;

use App\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{

    protected $fillable = [
        'course_id',
        'title',
        'content',
        'order'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
