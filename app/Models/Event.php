<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'name',
        'director',
        'activity_id',
        'agreement_id',
        'modality',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'event_country_id',
        'state_id',
        'city_id',
        'financial_country_id',
        'university_id',
        'financial_amount',
        'financial_international_amount',
        'financial_entity_id'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

    public function agreement()
    {
        return $this->belongsTo(Agreement::class);
    }

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

    public function financialCountry()
    {
        return $this->belongsTo(Country::class, 'financial_country_id');
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function financialEntity()
    {
        return $this->belongsTo(FinancialEntity::class);
    }
}
