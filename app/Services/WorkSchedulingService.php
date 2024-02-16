<?php

namespace App\Services;

use App\Models\DynamicWorkingSchedule;
use App\Models\Movement;
use App\Models\User;
use App\Services\Contracts\WorkSchedulingServiceContract;
use Illuminate\Support\Carbon;

class WorkSchedulingService implements WorkSchedulingServiceContract
{

    private $currentUser;
    private $userId;
    private $month;
    private $year;

    public function calculateEmployeeLateIncomes($userId = null, $month = null, $year = null)
    {

        $userId = $this->checkUserId($userId);
        $month = $month ?? $this->month;
        $year = $year ?? $this->year;

        $userWorkingWeekDays = $this->getUserWorkingWeekDays($userId);

        if ($userWorkingWeekDays == null) {
            return '';
        }

        $movements = $this->fetchUser($userId)
            ->movements()
            ->when($year, function ($q, $year) {
                return $q->whereYear('start_date', $year);
            })
            ->when($month, function ($q, $month) {
                return $q->whereMonth('start_date', $month);
            })->get();

        return collect($movements)->filter(function ($item) use ($userWorkingWeekDays) {
            return !$item->checkUser($userWorkingWeekDays);
        })->count();
    }

    public function calculateEmployeeGoEarly($userId = null, $month = null, $year = null)
    {

        $userId = $this->checkUserId($userId);
        $month = $month ?? $this->month;
        $year = $year ?? $this->year;

        $userWorkingWeekDays = $this->getUserWorkingWeekDays($userId);

        if ($userWorkingWeekDays == null) {
            return '';
        }

        $movements = $this->fetchUser($userId)
            ->movements()
            ->when($year, function ($q, $year) {
                return $q->whereYear('start_date', $year);
            })
            ->when($month, function ($q, $month) {
                return $q->whereMonth('start_date', $month);
            })->get();

        return collect($movements)->filter(function ($item) use ($userWorkingWeekDays) {
            return !$item->checkUser($userWorkingWeekDays, true);
        })->count();
    }

    public function calculateEmployeeWorkingAndMissedDays($userId = null, $month = null, $year = null)
    {
        $userId = $this->checkUserId($userId);
        $month = $month ?? $this->month;
        $year = $year ?? $this->year;
        $user = $this->fetchUser($userId);
        $weekDays = [];
        if ($user->working_schedule_id != 2){
            $workingWeekDays = $this->getUserWorkingWeekDays($userId);
            $weekDays = array_keys($workingWeekDays);
        }
        $mustWorkingDays = $this->monthWorkingDays($weekDays, $month, $year);
        $actualWorkingDaysCount = $this->fetchUser($userId)
            ->movements()
            ->when($year, function ($q, $year) {
                return $q->whereYear('start_date', $year);
            })
            ->when($month, function ($q, $month) {
                return $q->whereMonth('start_date', $month);
            })
            ->count();
        return [
            'working_days' => $mustWorkingDays,
            'actual_working_days' => $actualWorkingDaysCount,
            'missed_days' => $mustWorkingDays - $actualWorkingDaysCount,
        ];
    }

    private function getMonthDays($month = null, $year = null)
    {
        $monthResolved = $month ?? date('m');
        $yearResolved = $year ?? date('Y');
        return [
            'days' => cal_days_in_month(CAL_GREGORIAN, $monthResolved, $yearResolved),
            'month' => $monthResolved,
            'year' => $yearResolved
        ];
    }

    private function fetchUser($userId)
    {
        if ($this->currentUser == null || $this->currentUser->id != $userId) {
            $this->currentUser = User::with('movements', 'working_schedule')->find($userId);
        }

        return $this->currentUser;
    }

    public function getUser(): User
    {
        return $this->currentUser;
    }

    private function getUserWorkingWeekDays($userId)
    {
        $userId = $this->checkUserId($userId);
        $user = $this->fetchUser($userId);
        if ($user->working_schedule_id == 2){
            $dynamicWorkingScheduleDate = DynamicWorkingSchedule::where('user_id',$user->id)->whereNotIn('dynamic_working_schedule_time_id', [1])->count();
            return $dynamicWorkingScheduleDate;
        }
        return $this->fetchUser($userId)?->working_schedule?->week_days;
    }

    private function checkUserId($userId)
    {
        $userId = $userId ?? $this->userId;
        if (!$userId) {
            throw new \Exception("User Id not found");
        }
        return $userId;
    }

    public function calculateTotalWorkingTime($userId = null, $month = null, $year = null)
    {
        $userId = $this->checkUserId($userId);

        $month = $month ?? $this->month;
        $year = $year ?? $this->year;

        $workingTime = User::findOrFail($userId)
            ->movements()
            ->selectRaw('*, TIME_TO_SEC(TIMEDIFF(end_date, start_date)) as diff_in_sec')
            ->when($year, function ($q, $year) {
                return $q->whereYear('start_date', $year);
            })
            ->when($month, function ($q, $month) {
                return $q->whereMonth('start_date', $month);
            })
            ->get();
        $workingSeconds = $workingTime->sum('diff_in_sec');
        $hoursToSubtract = $workingTime->count();
        $timeToSubtract = ($hoursToSubtract * 60 * 60);
        $timeInPast = $workingSeconds - $timeToSubtract;
        return seconds2time($timeInPast);
    }

    public function fetchUserMovements($userId = null, $month = null, $year = null)
    {
        $userId = $this->checkUserId($userId);

        $month = $month ?? $this->month;
        $year = $year ?? $this->year;

        $movements = User::findOrFail($userId)
            ->movements()
            ->when($year, function ($q, $year) {
                return $q->whereYear('start_date', $year);
            })
            ->when($month, function ($q, $month) {
                return $q->whereMonth('start_date', $month);
            })
            ->get();
        return $movements;
    }


    //==========
    public function calculateTotalWorkingTimeForUsers($month = null, $year = null)
    {

        $month = $month ?? $this->month;
        $year = $year ?? $this->year;

        //$weekDays = $this->working_schedule?->week_days;
        //$startDateWeekDay = strtoupper(\Carbon\Carbon::parse($this->start_date)->format('l'));

        /*if (!in_array($startDateWeekDay, array_keys($weekDays))) {
            return 'X';
        }*/


        $workingTime = User::with('movements')
            ->selectRaw('*, TIME_TO_SEC(TIMEDIFF(end_date, start_date)) as diff_in_sec')
            ->when($year, function ($q, $year) {
                return $q->whereYear('start_date', $year);
            })
            ->when($month, function ($q, $month) {
                return $q->whereMonth('start_date', $month);
            })
            ->get();
        $workingSeconds = $workingTime->sum('diff_in_sec');
        $hoursToSubtract = $workingTime->count();
        $timeToSubtract = ($hoursToSubtract * 60 * 60);
        $timeInPast = $workingSeconds - $timeToSubtract;
        return seconds2time($timeInPast);
    }


    private function monthWorkingDays($workingSchedule, $month = null, $year = null)
    {
        $user = $this->getUser();
        if ($user->working_schedule_id == 2) {
            $countDynamicWorkingSchedule = DynamicWorkingSchedule::where('user_id', $user->id)
                ->whereNotIn('dynamic_working_schedule_time_id',[1])
                ->when($year, function ($q, $year) {
                    return $q->whereYear('date', $year);
                })
                ->when($month, function ($q, $month) {
                    return $q->whereMonth('date', $month);
                })->count();
            return $countDynamicWorkingSchedule;
        }
        $timeData = $this->getMonthDays($month, $year);
        for ($i = 1; $i <= $timeData['days']; $i++) {
            $date = $timeData['year'] . '/' . $timeData['month'] . '/' . $i;
            $weekDay = date('l', strtotime($date));

            if (in_array(strtoupper($weekDay), $workingSchedule)) {
                $workdays[] = $i;
            }
        }
        return count($workdays);
    }

    public function init($userId, $month = null, $year = null)
    {
        $this->userId = $userId;
        $this->month = $month;
        $this->year = $year;
    }
}
