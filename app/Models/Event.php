<?php

namespace App\Models;

use App\Enums\EventHasAgreementEnum;
use App\Enums\EventInternalizationAtHomeEnum;
use App\Enums\EventLocationEnum;
use App\Enums\EventModalityEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'career_id',
        'description',
    ];

    protected $casts = [
        'has_agreement' => EventHasAgreementEnum::class,
        'modality' => EventModalityEnum::class,
        'location' => EventLocationEnum::class,
        'internationalization_at_home' => EventInternalizationAtHomeEnum::class,
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
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

    public function career()
    {
        return $this->belongsTo(Career::class);
    }

    public function isActive(): bool
    {
        $now = Carbon::now();
        
        // Obtener fechas como objetos Carbon de los casts
        $startDateObj = $this->start_date; // Ya es Carbon por el cast
        $endDateObj = $this->end_date;     // Ya es Carbon por el cast
        
        // Obtener horas como objetos DateTime de los casts
        $startTimeObj = $this->start_time; // Ya es DateTime por el cast
        $endTimeObj = $this->end_time;     // Ya es DateTime por el cast
        
        // Extraer solo las partes de fecha y hora
        $startDate = $startDateObj->format('Y-m-d');
        $endDate = $endDateObj->format('Y-m-d');
        $startTime = $startTimeObj->format('H:i:s');
        $endTime = $endTimeObj->format('H:i:s');
        
        // Crear instancias Carbon completas combinando fecha y hora
        $startDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $startDate . ' ' . $startTime);
        $endDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $endDate . ' ' . $endTime);

        return $startDateTime->lte($now) && $endDateTime->gte($now);
    }
}
