<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityStatistic extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'activity_id',
        'total_events',
        'total_assistances',
    ];
    
    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
