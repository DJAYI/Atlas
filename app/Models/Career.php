<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = ['name', 'description', 'faculty_id'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
