<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PathOfPath extends Model
{
    protected $guarded =[];
    public function coursePath()
    {
        return $this->belongsTo(CoursesPath::class);
    }

    public function parent()
    {
        return $this->belongsTo(PathOfPath::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PathOfPath::class, 'parent_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

}