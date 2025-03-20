<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialEntity extends Model
{
    protected $fillable = ['name', 'description', 'code', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
