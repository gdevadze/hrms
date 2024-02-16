<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingSchedule extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'week_days' => 'array'
    ];

    public function getWorkedHours1()
    {
        // $workedHours = '-';
        $weekDays = $this->week_days;
        foreach ($weekDays as $weekDay){
            echo $weekDay;
        }
//        if ($this->start_date && $this->end_date){
//
//
//            $workedSeconds = Carbon::parse($this->start_date)->addHour()->diffInSeconds($this->end_date);
//            // $displayTime = gmdate('H:i:s',$workedHours);
//
//            $workedHours = (int)($workedSeconds / 3600);
//
//            return [
//                'value' => '',
//                'date' => $this->start_date,
//                'worked_hours' => ($workedHours > 0) ? $workedHours : 0
//            ];
//        }
//        return null;
    }
}
