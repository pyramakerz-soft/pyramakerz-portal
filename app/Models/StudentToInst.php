<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentToInst extends Model
{
    protected $guarded = [];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
