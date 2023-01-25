<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function checkUser($data = [],$late = false)
    {
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
            return  (date('H:i', strtotime($agenda['end_time'])) <= date('H:i', strtotime($this->end_date)));
        }
        return  (date('H:i', strtotime($agenda['start_time'])) >= date('H:i', strtotime($this->start_date)));
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
        $workedHours = '-';
        if ($this->end_date){
            $workedHours = Carbon::parse($this->start_date)->addHour()->diffInSeconds($this->end_date);
            $displayTime = gmdate('H:i:s',$workedHours);
        }
        return new Attribute(
            get: fn($value) => $displayTime ?? $workedHours
        );
    }
}
