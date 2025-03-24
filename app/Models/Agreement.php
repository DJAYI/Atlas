<?php

namespace App\Models;

use App\Enums\AgreementActivityEnum;
use App\Enums\AgreementTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
    protected $fillable = [
        'year',
        'semester',
        'code',
        'type',
        'activity',
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'type' => AgreementTypeEnum::class,
        'activity' => AgreementActivityEnum::class,
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    // Relación con Eventos (si aplica)
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
