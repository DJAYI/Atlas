<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'iso_code_alpha-3', 'iso_code'];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function universities()
    {
        return $this->hasMany(University::class);
    }
}
