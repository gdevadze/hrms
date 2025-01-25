<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\UserCompany;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TabelExport implements FromView,ShouldAutoSize
{
    protected $id;
    protected $selectedDate;
    public function __construct($format,$id,$selectedDate,$type)
    {
        $this->format = $format;
        $this->id = $id;
        $this->selectedDate = $selectedDate;
        $this->type = $type;
    }

    public function view(): View
    {
        $year = date('Y');
        $month = date('m');
        if($this->selectedDate){
            $year = explode('.',$this->selectedDate)[1];
            $month = explode('.',$this->selectedDate)[0];
            $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        }

        $monthDays = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        if ($this->type == 1){
            $users = UserCompany::where('company_id',$this->id)->where('status',1)->whereNotNull('working_schedule_id')->with('working_schedule')->get()
                ?->map?->getWorkedHoursByDay($year, $month);
        }else{
            $users = UserCompany::where('company_id', $this->id)->where('status',1)->whereNotNull('working_schedule_id')->with('working_schedule')->get()
                ?->map?->getWorkedHoursByDaySchedule($year, $month);
        }
        $company = Company::findOrFail($this->id);
        $date = Carbon::today()->format('d.m.Y');
        $startDate = Carbon::createFromFormat("Y-m-d", "{$year}-{$month}-01")->format('Y-m-d');
        $endDate = Carbon::createFromFormat("Y-m-d", "{$year}-{$month}-".$monthDays)->format('Y-m-d');
        if ($this->format == 1){
            return view('exports.report', [
                'users' => $users,
                'company' => $company,
                'date' => $date,
                'month_days' => $monthDays,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
        }else{
            return view('exports.worked_hours', [
                'users' => $users,
                'company' => $company,
                'date' => $date,
                'month_days' => $monthDays,
                'year' => $year,
                'month' => $month,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
        }

    }
}
