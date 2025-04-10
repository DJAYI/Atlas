<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assistance extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'person_id',
        'university_destiny_id',
        'mobility_id',
        'identity_document_file'
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

    public function mobility()
    {
        return $this->belongsTo(Mobility::class);
    }
}
