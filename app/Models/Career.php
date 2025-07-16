<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description', 'faculty_id'];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }
}
