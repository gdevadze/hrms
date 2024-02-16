<?php

namespace App\Models;

use App\Services\HonorableReasonService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name_ka',
        'surname_ka',
        'name_en',
        'surname_en',
        'tel',
        'personal_num',
        'email',
        'password',
        'working_schedule_id',
        'card_number',
        'birthdate',
        'company_id',
        'position_id'
    ];

    protected $appends = [
        'full_name',
        'formatted_birthdate'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function movements(): HasMany
    {
        return $this->hasMany(Movement::class);
    }

    public function working_schedule(): BelongsTo
    {
        return $this->belongsTo(WorkingSchedule::class);
    }

    public function dynamic_working_schedule(): HasMany
    {
        return $this->hasMany(DynamicWorkingSchedule::class);
    }

    public function user_vacation_quantities()
    {
        return $this->hasMany(UserVacationQuantity::class)->where('status',1);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function fullName(): Attribute
    {
        $fullName = $this->name_ka.' '.$this->surname_ka;
        if(currentLocale() != 'ka'){
            $fullName = $this->name_en.' '.$this->surname_en;
        }
        return new Attribute(
            get: fn($value) => $fullName
        );
    }

    public function fullNameEn(): Attribute
    {
        return new Attribute(
            get: fn($value) => $this->name_en.' '.$this->surname_en
        );
    }

    public function formattedBirthdate(): Attribute
    {
        $birthdate = '';
        if($this->birthdate){
            $birthdate = Carbon::parse($this->birthdate)->format('d.m.Y');
        }
        return new Attribute(
            get: fn() => $birthdate
        );
    }

    public function workedHoursByDay(): Attribute
    {
        $weekDays = $this->working_schedule?->week_days;
        $startDateWeekDay = strtoupper(Carbon::parse($this->start_date)->format('l'));

        if (isset($weekDays) && !in_array($startDateWeekDay, array_keys($weekDays))) {
            return new Attribute(
                get: fn() => 'X'
            );
        }
        $result = $this->movements?->map?->getWorkedHours1();
        return new Attribute(
            get: fn() => $result
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
                    'date' => $date
                ];
            }
            else {
                $movs = $this->movements
                    ->filter(function ($item) use ($date) {
                        $dateResolved = date('Y-m-d', strtotime($item->start_date));
                        return $dateResolved ==  $date->format('Y-m-d');
                    })
                    //->where('start_date', $date->format('Y-m-d'))
                    ?->map?->getWorkedHours1();
//                return $movs;
                $atNight = 0;
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
                    $vacation = $honorableReasonService->checkVacationStatus($this->id,$date);
                    $holidays = Holiday::where('date',Carbon::parse($date)->format('Y-m-d'))->first();
                    if($vacation || $holidays){

                        if($holidays){
                            $result[] = [
                                'value' => 'დ',
                                'week_day' => $weekDay,
                                'date' => Carbon::parse($date)->format('Y-m-d')
                            ];
                        }else{
                            $result[] = [
                                'value' => 'ა/შ',
                                'week_day' => $weekDay,
                                'date' => Carbon::parse($date)->format('Y-m-d')
                            ];
                        }
                    }else{
                        $result[] = [
                            'data' => $weekDays,
                            'value' => '',
                            'date' => $this->start_date,
                            'name' => $dateName,
                            'worked_hours' => ($workedHours > 0) ? $workedHours : 0
                        ];
                    }

                }
                else {
//                    $startDate = Carbon::parse($date)->format('Y-m-d');

                    $honorableReasonService = new HonorableReasonService();
                    $vacation = $honorableReasonService->checkVacationStatus($this->id,$date);

                    if($vacation){
                        $holidays = Holiday::where('date',Carbon::parse($date)->format('Y-m-d'))->first();
                        if($holidays){
                            $result[] = [
                                'value' => 'დ',
                                'week_day' => $weekDay,
                                'date' => Carbon::parse($date)->format('Y-m-d')
                            ];
                        }else{
                            $result[] = [
                                'value' => 'ა/შ',
                                'week_day' => $weekDay,
                                'date' => Carbon::parse($date)->format('Y-m-d')
                            ];
                        }
                    }else{
                        $dynamicWorkingScheduleDate = DynamicWorkingSchedule::with('dynamic_working_schedule_time')->where('user_id',$this->id)->where('date',Carbon::parse($date)->format('Y-m-d'))->first();
                        if($dynamicWorkingScheduleDate && $dynamicWorkingScheduleDate->dynamic_working_schedule_time_id == 1){
                            $result[] = [
                                'value' => 'დ'
                            ];
                        }else{
                            $workedHours = 0;
                            $value = '';
                            $endTime = '';
                            $workedSeconds = 0;
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
                                $holidays = Holiday::where('date',Carbon::parse($date)->format('Y-m-d'))->first();
                                if($holidays){
                                    $value = 'დ';
                                }
                            }

                            $result[] = [
                                'value' => $value,
                                'week_day' => $weekDay,
//                                'time' => $dynamicWorkingScheduleDate->dynamic_working_schedule_time->start_time.' - '.$dynamicWorkingScheduleDate->dynamic_working_schedule_time->end_time,
                                'end_time' => $endTime,
                                'date' => Carbon::parse($date)->format('Y-m-d'),
                                'movs' => $workedSeconds,
                                'worked_hours' => $workedHours,
                                'at_night' => $atNight
                            ];
                        }


                    }
                }
            }
        }
        $resultCollection = collect($result);
        $sum = $resultCollection->sum('worked_hours');
//        return $resultCollection;
        $mustWorkingDays = $resultCollection->filter(function ($item){
            return isset($item['value']) ? ($item['value'] != 'დ' && $item['value'] != 'გ') : '';
        })->count();
        $activeWorkingDays = $resultCollection->filter(function ($item){
            return isset($item['worked_hours']);
        })->count();
        $data = [
            'full_name' => $this->full_name,
            'personal_num' => $this->personal_num,
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
}
