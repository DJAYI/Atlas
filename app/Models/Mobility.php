<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobility extends Model
{
    protected $fillable = [
        'name',
        'type',
    ];
    protected $casts = [
        'type' => 'string',
    ];
    public function assistances()
    {
        return $this->hasMany(Assistance::class);
    }
}
