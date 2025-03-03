<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Use the Authenticatable class
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    // Relationship with student suggestions
    public function suggestions()
    {
        return $this->hasMany(StudentSuggesstion::class);
    }
    public function courseStudents()
    {
        return $this->hasMany(CourseStudent::class);
    }
    public function groupStudents()
    {
        return $this->hasMany(GroupStudent::class);
    }
    public function attendedMeetings()
{
    return $this->belongsToMany(Meeting::class, 'attendance_records')
                ->withTimestamps();
}
public function groups()
{
    return $this->hasManyThrough(Group::class, GroupStudent::class, 'student_id', 'id', 'id', 'group_id');
}

    public function progress()
    {
        return $this->hasMany(StudentProgress::class, 'student_id', 'id');
    }
    public function attendanceRecords() {
        return $this->hasMany(Attendance::class, 'user_id');
    }
    public function attendance() {
        return $this->hasMany(Attendance::class, 'user_id');
    }
    
    public function studentAttendance() {
        return $this->hasMany(Attendance::class, 'student_id');
    }
    
}