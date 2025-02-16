<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentTask extends Model
{
    protected $guarded =[];
    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id');
    }
}
