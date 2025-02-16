<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded =[];
    public function studentTasks()
    {
        return $this->hasMany(StudentTask::class, 'task_id');
    }
}
