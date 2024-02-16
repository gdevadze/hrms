<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TabelExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        $monthDays = cal_days_in_month(CAL_GREGORIAN, 1, 2024);
        $users = User::where('company_id',3)->where('status',1)->whereNotNull('working_schedule_id')->with('movements')->with('working_schedule')->get()
            ?->map?->getWorkedHoursByDay('2024', '1');
        $company = Company::findOrFail(2);
        $date = Carbon::today()->format('d.m.Y');
        return view('exports.report', [
            'users' => $users,
            'company' => $company,
            'date' => $date,
            'month_days' => $monthDays,
        ]);
    }
}
