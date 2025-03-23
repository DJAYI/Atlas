<?php

namespace App\Models;

use App\Casts\HasAgreement;
use App\Casts\Location;
use App\Casts\Modality;
use App\Casts\InternalizationAtHome;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use InternationalizationAtHomeEnum;

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
        'internationalization_at_home' => InternalizationAtHome::class,
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
}
