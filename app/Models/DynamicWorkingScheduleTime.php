<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DynamicWorkingScheduleTime extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function formattedStartTime(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->start_time)->format('H:i')
        );
    }

    public function formattedEndTime(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->end_time)->format('H:i')
        );
    }
}
