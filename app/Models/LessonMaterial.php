<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonMaterial extends Model
{
    use HasFactory;

    protected $fillable = ['lesson_id', 'instructor_id', 'group_id', 'title', 'type', 'url'];

    /**
     * Get the lesson this material belongs to.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * Get the instructor who uploaded the material.
     */
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the group this material is linked to.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
