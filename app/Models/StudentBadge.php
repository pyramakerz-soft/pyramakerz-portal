<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentBadge extends Model
{
    protected $guarded = [];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
    public function studentPoint()
    {
        return $this->belongsTo(StudentPoint::class);
    }
}
