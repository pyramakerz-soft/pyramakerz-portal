<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoursesPath extends Model
{
    protected $guarded = [];
    protected $table = 'course_paths';

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function paths()
    {
        return $this->hasMany(PathOfPath::class,'course_path_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'course_path_id');
    }

}