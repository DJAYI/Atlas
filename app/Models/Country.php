<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = ['name', 'code', 'phone_code'];

    public function states()
    {
        return $this->hasMany(State::class);
    }

    public function financialEntities()
    {
        return $this->hasMany(FinancialEntity::class);
    }
}
