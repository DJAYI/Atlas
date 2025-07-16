<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    
    // code alpha 3. Example: "COL" for Colombia and iso code "170"
    protected $fillable = ['name', 'iso_code_alpha_3', 'iso_code'];

    public function universities()
    {
        return $this->hasMany(University::class);
    }
}
