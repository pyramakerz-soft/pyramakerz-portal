<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $guarded = [];
    public function students()
    {
        return $this->belongsToMany(Student::class, 'group_students', 'group_id', 'student_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function instructor()
    {
        return $this->belongsTo(User::class,'instructor_id');
    }
    public function schedules()
    {
        return $this->hasMany(GroupSchedule::class);
    }
    
}
