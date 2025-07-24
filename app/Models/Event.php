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
        
        // Asegurar que tenemos instancias Carbon y combinar correctamente fecha y hora
        $startDate = Carbon::parse($this->start_date);
        $endDate = Carbon::parse($this->end_date);
        $startTime = Carbon::parse($this->start_time);
        $endTime = Carbon::parse($this->end_time);
        
        // Combinar fecha y hora usando setTime
        $startDateTime = $startDate->copy()->setTime(
            $startTime->hour,
            $startTime->minute,
            $startTime->second
        );
        
        $endDateTime = $endDate->copy()->setTime(
            $endTime->hour,
            $endTime->minute,
            $endTime->second
        );

        // Verificar si el momento actual está entre el inicio y fin del evento (inclusive)
        $isActive = $now->greaterThanOrEqualTo($startDateTime) && $now->lessThanOrEqualTo($endDateTime);
        
        // Log temporal para debug
        \Log::info("Event {$this->event_code} isActive check:", [
            'now' => $now->format('Y-m-d H:i:s'),
            'start' => $startDateTime->format('Y-m-d H:i:s'),
            'end' => $endDateTime->format('Y-m-d H:i:s'),
            'result' => $isActive
        ]);

        return $isActive;
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
