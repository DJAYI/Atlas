<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinancialEntity extends Model
{
<<<<<<< HEAD
    protected $fillable = ['name', 'description', 'code', 'country_id'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
=======
    protected $fillable = ['name', 'description', 'code'];
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
}
