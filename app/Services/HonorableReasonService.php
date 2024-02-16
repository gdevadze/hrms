<?php

namespace App\Services;

use App\Models\DynamicWorkingSchedule;
use App\Models\Holiday;
use App\Models\Vacation;
use Carbon\Carbon;

class HonorableReasonService
{
    public function getNextWorkingDate($userId,$workingSchedule,$date,$schedule) {
        if($workingSchedule != 2){
            $currentTime = Carbon::parse($date);
            $currentDay = $currentTime->format('l'); // Get the current day name

            $givenKey = strtoupper($currentDay);
            $nextKey = null;
            $nextValue = null;
            $foundGivenKey = false;

            foreach ($schedule as $key => $value) {
                if ($foundGivenKey) {
                    $nextKey = $key;
                    $nextValue = $value;
                    break;
                }

                if ($key === $givenKey) {
                    $foundGivenKey = true;
                }
            }
//        return $nextValue;
            if ($nextKey !== null) {
//            echo "Next key: $nextKey";
            } else {
                if (reset($schedule) !== false) {
                    $nextKey = key($schedule);
                    $nextValue = reset($schedule);
                } else {
                    echo "Array is empty";
                }
            }
            $nextWorkingDate = $currentTime->next($nextKey);
            $nextWorkingDate->setTimeFromTimeString($schedule[$nextKey]['start_time']);

            return $nextWorkingDate->format('d.m.Y');
        }else{
            $dynamicWorkingSchedule = DynamicWorkingSchedule::where('user_id',$userId)->where('date','>',$date)->where('dynamic_working_schedule_time_id','!=',1)->first();
            if ($dynamicWorkingSchedule){
                return Carbon::parse($dynamicWorkingSchedule->date)->format('d.m.Y');
            }
            return '-';
        }

    }

    public function getCurrectWorkingDay($schedule) {
        $currentTime = Carbon::today();
        $currentDay = $currentTime->format('l'); // Get the current day name

        $givenKey = strtoupper($currentDay);
        $nextKey = null;
        $nextValue = null;
        $foundGivenKey = false;

        foreach ($schedule as $key => $value) {
            if ($key === $givenKey) {
                $nextKey = $key;
                $nextValue = $value;
            }
        }
        if ($nextValue && $nextKey){
            return true;
        }
        return false;
    }

    public function isWorkingDay($date,$userId,$workingScheduleId,$schedule)
    {
        $holidays = Holiday::where('date',$date)->first();
        if($holidays){
            return false;
        }
        if($workingScheduleId != 2){
            $currentTime = Carbon::parse($date);
            $currentDay = $currentTime->format('l'); // Get the current day name

            $givenKey = strtoupper($currentDay);
            $nextKey = null;
            $nextValue = null;
            $foundGivenKey = false;

            foreach ($schedule as $key => $value) {
                if ($key === $givenKey) {
                    $nextKey = $key;
                    $nextValue = $value;
                }
            }
            if ($nextValue && $nextKey){
                $hours = Carbon::parse($nextValue['start_time'])->addHour()->diffInHours($nextValue['end_time']);
                return [true,$hours,$nextKey];
            }
            return false;
        }else{
            $dynamicWorkingSchedule = DynamicWorkingSchedule::where('user_id',$userId)->where('date',$date)->first();
            if ($dynamicWorkingSchedule && $dynamicWorkingSchedule->dynamic_working_schedule_time_id != 1){
                $hours = Carbon::parse($dynamicWorkingSchedule->dynamic_working_schedule_time->start_time)->addHour()->diffInHours($dynamicWorkingSchedule->dynamic_working_schedule_time->end_time);
                return [true,$hours,$date];
            }
            return false;
        }
    }

    public function calculateVacationDays($date,$userId,$workingScheduleId,$schedule)
    {
        $currentTime = Carbon::parse($date);
        $currentDay = $currentTime->format('l'); // Get the current day name

//        $givenKey = strtoupper($currentDay);
        $nextKey = null;
        $nextValue = null;
//        $foundGivenKey = false;
        $hours = 0;
        foreach ($schedule as $key => $value) {
//            if ($key === $givenKey) {
                $nextKey = $key;
                $nextValue = $value;
                $hours += Carbon::parse($nextValue['start_time'])->addHour()->diffInHours($nextValue['end_time']);
//                echo $nextKey.' - '.Carbon::parse($nextValue['start_time'])->addHour()->diffInHours($nextValue['end_time']).'<br>';
//            }
        }
        if ($nextValue && $nextKey){
            return $hours;
        }
        return false;

    }

    public function getCurrectWorkingDayEndDate($schedule) {
        $currentTime = Carbon::today();
        $currentDay = $currentTime->format('l'); // Get the current day name

        $givenKey = strtoupper($currentDay);
        $nextKey = null;
        $nextValue = null;
        $foundGivenKey = false;

        foreach ($schedule as $key => $value) {
            if ($key === $givenKey) {
                $nextKey = $key;
                $nextValue = $value;
            }
        }
        if ($nextValue && $nextKey){
            return $nextValue['end_time'];
        }
        return false;
    }

    public function checkVacationStatus($userId, $date): bool
    {
        $dateToCheck = Carbon::parse($date)->format('Y-m-d');

        // Query the vacations table to find if the date falls within any vacation period
        $vacation = Vacation::where('user_id', $userId)->where('start_date', '<=', $dateToCheck)
            ->where('end_date', '>=', $dateToCheck)
            ->where('status',2)
            ->first();

        if ($vacation) {
            return true;
        } else {
            return false;
        }
    }

    public function countVacationDays($userId,$startDate, $endDate, $workingScheduleId,$scheduleJson)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $days = 0;
        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            if($this->isWorkingDay($date->toDateString(),$userId,$workingScheduleId,$scheduleJson)){
//                return $this->isWorkingDay($date->toDateString(),$userId,$workingScheduleId,$scheduleJson);
                $days += (int)$this->isWorkingDay($date->toDateString(),$userId,$workingScheduleId,$scheduleJson)[1];
//                echo $this->isWorkingDay($date->toDateString(),$userId,$workingScheduleId,$scheduleJson)[2].' - '.(int)$this->isWorkingDay($date->toDateString(),$userId,$workingScheduleId,$scheduleJson)[1].'<br>';
            }
        }
        return $days / 7;
    }

}
