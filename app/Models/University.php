<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = ['city_id', 'name', 'code', 'description'];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }
}
