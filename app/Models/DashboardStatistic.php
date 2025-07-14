<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardStatistic extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'year',
        'location',
        'modality',
        'role',
        'direction',
        'count',
    ];
}
