<?php

namespace App\Models;

<<<<<<< HEAD
=======
use AgreementActivityEnum;
use AgreementTypeEnum;
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
use Illuminate\Database\Eloquent\Model;

class Agreement extends Model
{
<<<<<<< HEAD
    protected $fillable = ['name', 'description', 'university_id'];

    public function university()
    {
        return $this->belongsTo(University::class);
    }

=======
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
>>>>>>> 59d1c10bf4a9a1cd11dba6c43e502062676d2e99
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
