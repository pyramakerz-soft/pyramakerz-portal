<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $guarded = [];
    //user relationship
    public function user()
    {
        return $this->belongsTo(Student::class);
    }
    //ticket replies relationship
    

}
