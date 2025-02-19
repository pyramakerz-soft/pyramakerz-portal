<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable; // Use the Authenticatable class
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'country',
        'city',
        'school',
        'gender',
        'bday',
        'photo',
    ];

    // Relationship with student suggestions
    public function suggestions()
    {
        return $this->hasMany(StudentSuggesstion::class);
    }
    public function progress()
    {
        return $this->hasMany(StudentProgress::class, 'student_id', 'id');
    }
    public function attendanceRecords() {
        return $this->hasMany(Attendance::class, 'user_id');
    }
    
    public function studentAttendance() {
        return $this->hasMany(Attendance::class, 'student_id');
    }
    
}