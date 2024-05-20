<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class DynamicWorkingScheduleExport implements FromView,ShouldAutoSize
{
    public function view(): View
    {
        $users = User::where('working_schedule_id', 2)->where('company_id',1)->where('status',1)->get();
        $year = 2024;
        $month = str_pad(9, 2, '0', STR_PAD_LEFT);
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, 2023);
        $monthName = getMonthName($month);
        return view('exports.dynamic_working_schedule', [
            'users' => $users,
            'year' => $year,
            'month' => $month,
            'daysInMonth' => $daysInMonth,
            'monthName' => $monthName,
        ]);
    }
}
