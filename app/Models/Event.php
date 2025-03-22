<?php

namespace App\Models;

use HasAgreement;
use Illuminate\Database\Eloquent\Model;
use InternationalizationAtHome;
use Location;
use Modality;

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
        'has_agreement' => HasAgreement::class,
        'modality' => Modality::class,
        'location' => Location::class,
        'internationalization_at_home' => InternationalizationAtHome::class,
        'start_date' => 'date',
        'end_date' => 'date',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'financial_value' => 'float',
        'financial_international_value' => 'float'
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

    // Relación con University
    public function university()
    {
        return $this->belongsToMany(University::class);
    }
}
