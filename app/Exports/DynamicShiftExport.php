<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\UserCompany;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DynamicShiftExport implements FromView,ShouldAutoSize
{
    protected $id;
    protected $selectedDate;
    public function __construct($id,$selectedDate)
    {
        $this->id = $id;
        $this->selectedDate = $selectedDate;
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
        $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $users = UserCompany::where('company_id', $this->id)->where('status',1)->whereNotNull('working_schedule_id')->where('working_schedule_id',2)
            ->get();
        $company = Company::findOrFail($this->id);
        $date = Carbon::today()->format('d.m.Y');
        return view('exports.dynamic_shift', compact('month_days','users','company','date','year','month'));
    }
}
