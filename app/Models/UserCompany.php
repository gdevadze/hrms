<?php

namespace App\Models;

use App\Enums\ContactType;
use App\Services\HonorableReasonService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserCompany extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function working_schedule(): BelongsTo
    {
        return $this->belongsTo(WorkingSchedule::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function dynamic_working_schedule(): HasMany
    {
        return $this->hasMany(DynamicWorkingSchedule::class,'user_id','user_id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function formattedContractDate(): Attribute
    {
        $contractDate = '';
        if($this->contract_date){
            $contractDate = Carbon::parse($this->contract_date)->format('d.m.Y');
        }
        return new Attribute(
            get: fn() => $contractDate
        );
    }

    public function formattedContractEndDate(): Attribute
    {
        $contractEndDate = '';
        if($this->contract_end_date){
            $contractEndDate = Carbon::parse($this->contract_end_date)->format('d.m.Y');
        }
        return new Attribute(
            get: fn() => $contractEndDate
        );
    }

    public function formattedContractType(): Attribute
    {
        $contractType = '';
        if($this->contract_type_id){
            $contractType = ContactType::getData($this->contract_type_id);
        }
        return new Attribute(
            get: fn() => $contractType
        );
    }

    public function getWorkedHoursByDay($year, $month)
    {
        $weekDays = $this->working_schedule?->week_days;
        $startDateWeekDay = strtoupper(Carbon::parse($this->start_date)->format('l'));

        $monthResolved = $month ?? date('m');
        $yearResolved = $year ?? date('Y');
        $monthDaysCount = cal_days_in_month(CAL_GREGORIAN, $monthResolved, $yearResolved);

        $result = [];
        for ($i = 1; $i <= $monthDaysCount; $i++) {
            $date = Carbon::createFromFormat("Y-m-d", "{$yearResolved}-{$monthResolved}-{$i}");

            $weekDay = strtoupper(Carbon::parse($date)->format('l'));

            if ($this->working_schedule_id != 2 && !in_array($weekDay, array_keys($weekDays))) {
                $result[] = [
                    'value' => 'დ',
                    'week_day' => $weekDay,
                    'date' => $date,
                    'status' => 0
                ];
            }
            else {
//                $movs = $this->movements
//                    ->filter(function ($item) use ($date) {
//                        $dateResolved = date('Y-m-d', strtotime($item->start_date));
//                        return $dateResolved ==  $date->format('Y-m-d');
//                    })
//                    //->where('start_date', $date->format('Y-m-d'))
//                    ?->map?->getWorkedHours1();
//                return $movs;
                $atNight = 0;
                $overtime = 0;
//                if ($this->working_schedule_id != 2 && count($movs)) {
//                    foreach ($movs as $mov) {
//                        $result[] = $mov;
//                    }
//                }
                if($this->working_schedule_id != 2){
                    $dateName = Carbon::parse($date)->format('l');
//                    $weekDays = collect($this->working_schedule->week_days);
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
                    $honorableReasonService = new HonorableReasonService();
                    $vacation = $honorableReasonService->checkVacationStatus($this->user_id,$date);
                    $holidays = Holiday::where('date',Carbon::parse($date)->format('Y-m-d'))->first();
                    if($vacation || $holidays){

                        if($holidays){
                            $result[] = [
                                'value' => 'დ',
                                'week_day' => $weekDay,
                                'date' => Carbon::parse($date)->format('Y-m-d'),
                                'status' => 0
                            ];
                        }else{
                            $result[] = [
                                'value' => 'ა/შ',
                                'week_day' => $weekDay,
                                'date' => Carbon::parse($date)->format('Y-m-d'),
                                'status' => 0
                            ];
                        }
                    }else{
                        $result[] = [
                            'data' => $weekDays,
                            'value' => '',
                            'date' => $this->start_date,
                            'name' => $dateName,
                            'worked_hours' => ($workedHours > 0) ? $workedHours : 0,
                            'status' => 0
                        ];
                    }

                }
                else {
//                    $startDate = Carbon::parse($date)->format('Y-m-d');

                    $honorableReasonService = new HonorableReasonService();
                    $vacation = $honorableReasonService->checkVacationStatus($this->user_id,$date);

                    if($vacation){
                        $holidays = Holiday::where('date',Carbon::parse($date)->format('Y-m-d'))->first();
                        if($holidays){
                            $result[] = [
                                'value' => 'დ',
                                'week_day' => $weekDay,
                                'date' => Carbon::parse($date)->format('Y-m-d'),
                                'status' => 0
                            ];
                        }else{
                            $result[] = [
                                'value' => 'ა/შ',
                                'week_day' => $weekDay,
                                'date' => Carbon::parse($date)->format('Y-m-d'),
                                'status' => 0
                            ];
                        }
                    }else{
                        $dynamicWorkingScheduleDate = DynamicWorkingSchedule::with('dynamic_working_schedule_time')->where('user_id',$this->user_id)->where('date',Carbon::parse($date)->format('Y-m-d'))->first();
                        if($dynamicWorkingScheduleDate && $dynamicWorkingScheduleDate->dynamic_working_schedule_time_id == 1){
                            $result[] = [
                                'value' => 'დ',
                                'status' => 0
                            ];
                        }else{
                            $workedHours = 0;
                            $value = '';
                            $endTime = '';
                            $workedSeconds = 0;
                            $holiday = Holiday::where('date',Carbon::parse($date)->format('Y-m-d'))->first();
                            if($dynamicWorkingScheduleDate){
                                $minutesOfDelay = generalSetting('minutes_of_delay') * 60;
//                                if($this->company_id == 2 && $weekDay != 'SATURDAY'){
//                                    $workedSeconds = Carbon::parse($dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time)->addHour()->diffInSeconds($dynamicWorkingScheduleDate->dynamic_working_schedule_time->end_time) + $minutesOfDelay;
//                                }else if($this->company_id == 4){
//                                    $workedSeconds = Carbon::parse($dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time)->addHour()->diffInSeconds($dynamicWorkingScheduleDate->dynamic_working_schedule_time->end_time) + $minutesOfDelay;
//                                }else if($this->company_id == 1 && $dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time >= '21:00'){
//                                    $firstTime = Carbon::createFromTimeString($dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time);
//                                    $secondTime = Carbon::createFromTimeString($dynamicWorkingScheduleDate->dynamic_working_schedule_time->end_time)->addDay();
//                                    $endTime = $firstTime->diffInHours($secondTime);
//                                    $workedSeconds = 0;
//                                    $atNight += 1;
//                                }
//                                else{
//                                    $workedSeconds = Carbon::parse($dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time)->diffInSeconds($dynamicWorkingScheduleDate->dynamic_working_schedule_time->end_time) + $minutesOfDelay;
//                                }

                                if($dynamicWorkingScheduleDate->dynamic_working_schedule_time->break_duration){
                                    if($this->company_id == 1 && $dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time > '21:00'){
                                        $firstTime = Carbon::createFromTimeString($dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time);
                                        $secondTime = Carbon::createFromTimeString($dynamicWorkingScheduleDate->dynamic_working_schedule_time->end_time)->addDay();
                                        $endTime = calculateNightHours($firstTime,$secondTime);
//                                        $endTime = $firstTime->addMinutes($dynamicWorkingScheduleDate->dynamic_working_schedule_time->break_duration)->diffInHours($secondTime);
                                        $workedSeconds = 0;
                                        $atNight += $endTime;
                                    }else{
                                        $workedSeconds = Carbon::parse($dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time)->addMinutes($dynamicWorkingScheduleDate->dynamic_working_schedule_time->break_duration)->diffInSeconds($dynamicWorkingScheduleDate->dynamic_working_schedule_time->end_time) + $minutesOfDelay;
                                    }
                                }else{
                                    $workedSeconds = Carbon::parse($dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time)->diffInSeconds($dynamicWorkingScheduleDate->dynamic_working_schedule_time->end_time) + $minutesOfDelay;
                                }
                                if($workedSeconds > 0){
                                    $workedHours = (int)($workedSeconds / 3600);
                                }else{
                                    $workedHours = $endTime;
                                }
                            }else{
                                $value = 'გ';
                                if ($dynamicWorkingScheduleDate && $dynamicWorkingScheduleDate->dynamic_working_schedule_time_id == 1){
                                    $value = 'დ';
                                }

                                if($holiday){
                                    $value = 'დ';
                                }
                            }
                            if($holiday){
                                $overtime += $workedHours;
                            }
                            $leave = 0;
//                            if ($this->contract_date && Carbon::parse($this->contract_date) > Carbon::parse($date)){
//                                $value = 'ას';
//                                $leave = 1;
//                            }
//
//                            if ($this->contract_end_date && Carbon::parse($this->contract_end_date) < Carbon::parse($date)){
//                                $value = 'ას';
//                                $workedHours = 0;
//                                $leave = 2;
//                            }

                            $result[] = [
                                'value' => $value,
                                'week_day' => $weekDay,
                                'end_time' => $endTime,
                                'date' => Carbon::parse($date)->format('Y-m-d'),
                                'worked_hours' => $workedHours,
                                'at_night' => $atNight,
                                'status' => $leave,
                                'overtime' => $overtime
                            ];
                        }


                    }
                }
            }
        }
        $resultCollection = collect($result);
        $sum = $resultCollection->sum('worked_hours');
        $mustWorkingDays = $resultCollection->filter(function ($item){
            return isset($item['value']) ? ($item['value'] != 'დ' && $item['status'] == 0 && $item['value'] != 'გ') : '';
        })->count();
        $activeWorkingDays = $resultCollection->filter(function ($item){
            return isset($item['worked_hours']);
        })->count();
        $data = [
            'full_name' => $this->user->full_name,
            'personal_num' => $this->user->personal_num,
            'position_title' => $this->position->title ?? '',
            'summary_worked_hours' => $sum,
            'must_working_days' => $mustWorkingDays,
            'active_working_days' => $activeWorkingDays,
            'working_schedule_id' => $this->working_schedule_id,
            'at_night' => $atNight,
            'position_name' => $this->position->title ?? ''
        ];



        return [
            'data' => $data,
            'result' => $result
        ];
    }

    public function getWorkedHoursByDaySchedule($year, $month)
    {
        $weekDays = $this->working_schedule?->week_days;
        $yearResolved = $year ?? date('Y');
        $monthResolved = str_pad($month ?? date('m'), 2, '0', STR_PAD_LEFT);
        $monthDaysCount = cal_days_in_month(CAL_GREGORIAN, $monthResolved, $yearResolved);

        $vacationService = new HonorableReasonService();
        $holidays = Holiday::whereBetween('date', ["$yearResolved-$monthResolved-01", "$yearResolved-$monthResolved-$monthDaysCount"])
            ->pluck('date')
            ->flip();

        $dynamicSchedules = DynamicWorkingSchedule::with('dynamic_working_schedule_time')
            ->where('user_id', $this->user_id)
            ->whereBetween('date', ["$yearResolved-$monthResolved-01", "$yearResolved-$monthResolved-$monthDaysCount"])
            ->get()
            ->keyBy('date');

        $result = [];
        for ($i = 1; $i <= $monthDaysCount; $i++) {
            $date = Carbon::create($yearResolved, $monthResolved, $i)->format('Y-m-d');
            $weekDay = strtoupper(Carbon::parse($date)->format('l'));

            if ($this->working_schedule_id != 2 && !isset($weekDays[$weekDay])) {
                $result[] = ['value' => 'დ', 'week_day' => $weekDay, 'date' => $date, 'status' => 0];
                continue;
            }

            $movements = $this->user->movements
                ->filter(fn($item) => Carbon::parse($item->start_date)->format('Y-m-d') == $date)
                ->map->getWorkedHours();

            if ($movements->isNotEmpty()) {
                $result = array_merge($result, $movements->toArray());
                continue;
            }

            // Vacation & Holiday Checks
            if ($vacationService->checkVacationStatus($this->user_id, $date)) {
                $result[] = [
                    'value' => isset($holidays[$date]) ? 'დ' : 'ა/შ',
                    'week_day' => $weekDay,
                    'date' => $date,
                    'status' => 0
                ];
                continue;
            }

            // Dynamic Schedule Check
            $dynamicSchedule = $dynamicSchedules[$date] ?? null;
            $value = ($dynamicSchedule && $dynamicSchedule->dynamic_working_schedule_time_id == 1) ? 'დ' : 'გ';
            if (isset($holidays[$date])) $value = 'დ';

            $result[] = [
                'value' => $value,
                'week_day' => $weekDay,
                'date' => $date,
                'worked_hours' => 0,
                'status' => 0
            ];
        }

        $summary = collect($result);
        return [
            'data' => [
                'full_name' => $this->user->full_name,
                'personal_num' => $this->user->personal_num,
                'position_title' => $this->position->title ?? '',
                'summary_worked_hours' => $summary->sum('worked_hours'),
                'must_working_days' => $summary->whereNotIn('value', ['დ', 'გ'])->count(),
                'active_working_days' => $summary->whereNotNull('worked_hours')->count(),
            ],
            'result' => $result
        ];
    }
}
