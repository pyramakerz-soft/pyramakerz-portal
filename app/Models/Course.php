<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public function paths()
    {
        return $this->hasMany(CoursesPath::class);
    }

    public function suggestions()
    {
        return $this->hasMany(StudentSuggesstion::class);
    }

}