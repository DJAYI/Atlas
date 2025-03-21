<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Database\Eloquent\Model;
=======
use HasAgreement;
use Illuminate\Database\Eloquent\Model;
use InternationalizationAtHome;
use Location;
use Modality;
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99

class Event extends Model
{
    protected $fillable = [
        'name',
<<<<<<< HEAD
        'director',
        'activity_id',
        'agreement_id',
        'modality',
=======
        'responsable',
        'activity_id',
        'event_code',
        'has_agreement',
        'agreement_id',
        'modality',
        'location',
        'internationalization_at_home',
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
        'start_date',
        'end_date',
        'start_time',
        'end_time',
<<<<<<< HEAD
        'event_country_id',
        'state_id',
        'city_id',
        'financial_country_id',
        'university_id',
        'financial_amount',
        'financial_international_amount',
        'financial_entity_id'
    ];

=======
        'financial_country_id',
        'university_id',
        'financial_value',
        'financial_international_value',
        'financial_entity_id'
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
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

<<<<<<< HEAD
=======
    // Relación con Agreement (nullable)
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

<<<<<<< HEAD
    public function country()
    {
        return $this->belongsTo(Country::class, 'event_country_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

=======
    // Relación con Country (financial_country_id)
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
    public function financialCountry()
    {
        return $this->belongsTo(Country::class, 'financial_country_id');
    }

<<<<<<< HEAD
    public function university()
    {
        return $this->belongsTo(University::class);
    }

=======
    // Relación con University
    public function university()
    {
        return $this->belongsToMany(University::class);
    }

    // Relación con FinancialEntity
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
    public function financialEntity()
    {
        return $this->belongsTo(FinancialEntity::class);
    }
}
