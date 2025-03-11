<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Badge extends Model
{
    protected $guarded = [];
    public function studentBadges()
    {
        return $this->hasMany(StudentBadge::class);
    }
    
}
