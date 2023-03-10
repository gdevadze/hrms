<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingSchedule extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'week_days' => 'array'
    ];
}
