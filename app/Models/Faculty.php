<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    protected $fillable = ['name', 'code', 'description'];

    public function careers()
    {
        return $this->hasMany(Career::class);
    }
}
