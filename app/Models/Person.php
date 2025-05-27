<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'middlename',
        'lastname',
        'second_lastname',
        'document_type',
        'document_number',
        'email',
        'institutional_email',
        'phone',
        'university_id',
        'genre',
        'birth_date',
        'minority',
        'country_id',
        'type',
        'career_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'document_type' => 'string',
        'genre' => 'string',
        'minority' => 'string',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function career()
    {
        return $this->belongsTo(Career::class);
    }
}
