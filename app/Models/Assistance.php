<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    protected $fillable = [
        'event_id',
        'person_id',
        'university_destiny_id',
        'career_id',
        'mobility_id',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function person()
    {
        return $this->belongsTo(Person::class);
    }

    public function universityDestiny()
    {
        return $this->belongsTo(University::class, 'university_destiny_id');
    }

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function mobility()
    {
        return $this->belongsTo(Movility::class);
    }
}
