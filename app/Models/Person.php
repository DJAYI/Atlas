<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
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
        'address',
        'university_id',
        'genre',
        'birth_date',
        'minority',
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function university()
    {
        return $this->belongsTo(University::class);
    }
}
