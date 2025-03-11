<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $guarded = [];
    public function coursePath()
    {
        return $this->belongsTo(CoursesPath::class);
    }

    public function pathOfPath()
    {
        return $this->belongsTo(PathOfPath::class);
    }
    public function materials()
    {
        return $this->hasMany(LessonMaterial::class);
    }
public function resources()
{
    return $this->hasMany(LessonResource::class);
}



}