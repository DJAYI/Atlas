<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class University extends Model
{
    protected $fillable = ['country', 'name', 'code', 'description'];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function agreements()
    {
        return $this->hasMany(Agreement::class);
    }

    public function events(): BelongsToMany
    {
        return $this->belongsToMany(Event::class, 'event_university')->withTimestamps();
    }
}
