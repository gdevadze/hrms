<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Movement extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $appends = [
        'week_day_name'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dynamic_working_schedule(): BelongsTo
    {
        return $this->belongsTo(DynamicWorkingSchedule::class);
    }

    public function working_schedule(): BelongsTo
    {
        return $this->belongsTo(WorkingSchedule::class);
    }

    public function checkUser($data = [],$late = false)
    {
        $minutesOfDelay = generalSetting('minutes_of_delay') * 60;
        if($this->working_schedule_id == 2 && $this->dynamic_working_schedule_id){
            $dynamicWorkingScheduleDate = DynamicWorkingSchedule::where('user_id',$this->user_id)->where('date',Carbon::parse($this->start_date)->format('Y-m-d'))->first();
            $date = $dynamicWorkingScheduleDate;
            if($date){
                if ($late){
                    return (date('H:i', strtotime($date->dynamic_working_schedule_time->end_time)) <= date('H:i', strtotime($this->end_date)));
                }

                return (date('H:i', strtotime($date->dynamic_working_schedule_time->start_time)) >= date('H:i', strtotime($this->start_date) - $minutesOfDelay));
            }
        }
        $date = $this->start_date;
        if ($late){
            $date = $this->end_date;
        }
        $weekDay = strtoupper(Carbon::parse($date)->format('l'));
        $agenda = $data[$weekDay] ?? null;
        if ($agenda == null) {
            return true;
        }
        if ($late){
            return (date('H:i', strtotime($agenda['end_time'])) <= date('H:i', strtotime($this->end_date)));
        }
        return (date('H:i', strtotime($agenda['start_time'])) >= date('H:i', strtotime($this->start_date) - $minutesOfDelay));
    }

    public function checkUserLate($data = [])
    {
        $date = $this->start_date;
        $minutesOfDelay = generalSetting('minutes_of_delay') * 60;
        if($this->working_schedule_id == 2 && $this->dynamic_working_schedule_id){
            $dynamicWorkingScheduleDate = DynamicWorkingSchedule::where('user_id',$this->user_id)->where('date',Carbon::parse($this->start_date)->format('Y-m-d'))->first();
            $date = $dynamicWorkingScheduleDate;
            if($date){
                return (date('H:i', strtotime($date->dynamic_working_schedule_time->start_time)) >= date('H:i', strtotime($this->start_date) - $minutesOfDelay));
            }
        }
        $weekDay = strtoupper(Carbon::parse($date)->format('l'));
        $agenda = $data[$weekDay] ?? null;
        if ($agenda == null) {
            return true;
        }
        $formattedDate = Carbon::parse($date)->format('Y-m-d');

        return  date($formattedDate.' '.' H:i', strtotime($agenda['start_time']));
    }


    public function weekDayName(): Attribute
    {
        Carbon::setLocale(currentLocale());
        return new Attribute(
            get: fn($value) => Carbon::parse($this->start_date)->translatedFormat('l')
        );
    }

    public function formattedStartDate(): Attribute
    {
        return new Attribute(
            get: fn() => Carbon::parse($this->start_date)->format('d.m.Y H:i')
        );
    }

    public function formattedEndDate(): Attribute
    {
        return new Attribute(
            get: fn() => $this->end_date ? Carbon::parse($this->end_date)->format('d.m.Y H:i') : '-'
        );
    }

    public function workedHours(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->getWorkedHours()
        );
    }

    public function getWorkedHours()
    {
        $workedHours = '-';
        if ($this->end_date){
            $workedHours = Carbon::parse($this->start_date)->addHour()->diffInSeconds($this->end_date);
            $displayTime = (int)gmdate('H:i:s',$workedHours);
            $minutes = (int)gmdate('i',$workedHours);
        }
        return [
            'hours' => $displayTime ?? $workedHours,
            'minutes' => $minutes ?? 0
        ];
    }

    public function getWorkedHours1()
    {
       // $workedHours = '-';

        if ($this->start_date){
            $dateName = Carbon::parse($this->start_date)->format('l');
            $weekDays = collect($this->working_schedule?->week_days);
            $workedSeconds = 0;
            foreach ($weekDays as $key => $weekDay){
                if($key == strtoupper($dateName)){
                    if(isset($weekDay['break_duration'])){
                        $workedSeconds = Carbon::parse($weekDay['start_time'])->addMinutes($weekDay['break_duration'])->diffInSeconds($weekDay['end_time']);
                    }else{
                        $workedSeconds = Carbon::parse($weekDay['start_time'])->diffInSeconds($weekDay['end_time']);
                    }
                }
//                echo $weekDay['start_time'];
            }

           // $displayTime = gmdate('H:i:s',$workedHours);

            $workedHours = (int)($workedSeconds / 3600);

            return [
                'data' => $weekDays,
                'value' => '',
                'date' => $this->start_date,
                'name' => $dateName,
                'worked_hours' => ($workedHours > 0) ? $workedHours : 0
            ];
        }
        return null;
    }
}
