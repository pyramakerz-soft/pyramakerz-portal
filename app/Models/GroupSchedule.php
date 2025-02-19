<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupSchedule extends Model
{
    protected $guarded = [];
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }
}
