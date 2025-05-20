<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'responsable',
        'activity_id',
        'event_code',
        'has_agreement',
        'agreement_id',
        'modality',
        'location',
        'internationalization_at_home',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'university_id',
    ];

    protected $casts = [
        'has_agreement' => 'string',
        'modality' => 'string',
        'location' => 'string',
        'internationalization_at_home' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i', // ✅ Formato correcto
        'end_time' => 'datetime:H:i',   // ✅ Formato correcto
    ];

    // Relación con Activity
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    // Relación con Agreement (nullable)
    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

    public function universities()
    {
        return $this->belongsToMany(University::class, 'event_university', 'event_id', 'university_id');
    }

    public function assistances()
    {
        return $this->hasMany(Assistance::class);
    }

    public function isActive(): bool
    {
        $now = Carbon::now();

        return Carbon::parse($this->start_date)->lte($now) && Carbon::parse($this->end_date)->gte($now);
    }
}
