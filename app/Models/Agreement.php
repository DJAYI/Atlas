<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = ['name', 'description', 'university_id'];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
