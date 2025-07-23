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
        'significant_results',
        'photographic_support',
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
        'photographic_support' => 'array',
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

    /**
     * Obtiene las URLs públicas de los archivos de soporte fotográfico
     */
    public function getPhotographicSupportUrls(): array
    {
        if (!$this->photographic_support) {
            return [];
        }

        return array_map(function ($file) {
            return [
                'name' => basename($file),
                'url' => asset('storage/' . $file),
                'path' => $file
            ];
        }, $this->photographic_support);
    }

    /**
     * Añade archivos al soporte fotográfico
     */
    public function addPhotographicSupportFiles(array $files): void
    {
        $currentFiles = $this->photographic_support ?? [];
        $this->photographic_support = array_merge($currentFiles, $files);
        $this->save();
    }

    /**
     * Elimina un archivo específico del soporte fotográfico
     */
    public function removePhotographicSupportFile(string $filePath): bool
    {
        $currentFiles = $this->photographic_support ?? [];
        $updatedFiles = array_filter($currentFiles, fn($file) => $file !== $filePath);
        
        if (count($updatedFiles) !== count($currentFiles)) {
            $this->photographic_support = array_values($updatedFiles);
            $this->save();
            
            // Eliminar archivo físico del storage
            if (\Storage::disk('public')->exists($filePath)) {
                \Storage::disk('public')->delete($filePath);
            }
            
            return true;
        }
        
        return false;
    }
}
