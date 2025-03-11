<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupStudent extends Model
{
    use HasFactory;

    protected $fillable = ['group_id', 'student_id', 'instructor_id'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
