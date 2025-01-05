<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function coursePath()
    {
        return $this->belongsTo(CoursesPath::class);
    }

    public function pathOfPath()
    {
        return $this->belongsTo(PathOfPath::class);
    }


}