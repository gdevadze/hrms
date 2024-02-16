<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DynamicWorkingSchedule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function dynamic_working_schedule_time(): BelongsTo
    {
        return $this->belongsTo(DynamicWorkingScheduleTime::class);
    }

    public function formattedDate(): Attribute
    {
        return new Attribute(
            get: fn () => Carbon::parse($this->date)->format('d.m.Y')
        );
    }

    public function formattedWeekDayName(): Attribute
    {
        Carbon::setLocale(currentLocale());
        return new Attribute(
            get: fn () => Carbon::parse($this->date)->translatedFormat('l')
        );
    }

    public function getWorkedHours1()
    {
        // $workedHours = '-';

        if ($this->start_date && $this->end_date){

            $minutesOfDelay = generalSetting('minutes_of_delay') * 60;

            $workedSeconds = Carbon::parse($this->dynamic_working_schedule_time->start_time)->addHour()->diffInSeconds($this->dynamic_working_schedule_time->end_time) + $minutesOfDelay;

            $workedHours = (int)($workedSeconds / 3600);

            return [
                'value' => '',
                'date' => $this->start_date,
                'worked_hours' => ($workedHours > 0) ? $workedHours : 0
            ];
        }
        return null;
    }
}
