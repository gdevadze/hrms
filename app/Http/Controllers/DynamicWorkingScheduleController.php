<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\DynamicWorkingSchedule;
use App\Models\DynamicWorkingScheduleTime;
use App\Models\User;
use App\Models\UserCompany;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class DynamicWorkingScheduleController extends Controller
{
    public function index(): View
    {
        $companies = Company::all();
        return view('pages.working_schedule.dynamic_working_schedule', compact('companies'));
    }

    public function ajax(Request $request): JsonResponse
    {
        if (!$request->company_id){
            return jsonResponse(['status' => 2,'error' => 'გთხოვთ აირჩიოთ კომპანია!']);
        }
        $companyId = $request->company_id;
        $users = UserCompany::where('working_schedule_id', 2)->where('company_id',$companyId)->where('status',1)->get();
        $year = date('Y');
        $month = date('m');
        if($request->selected_date){
            $year = explode('.',$request->selected_date)[1];
            $month = explode('.',$request->selected_date)[0];
            $month = str_pad($month, 2, '0', STR_PAD_LEFT);

        }
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dynamicWorkingScheduleTime = DynamicWorkingScheduleTime::all();
        $monthName = getMonthName($month);
        return jsonResponse(['html' => view('general.working_schedule.dynamic_working_schedule', compact('users','month','year','daysInMonth','dynamicWorkingScheduleTime','monthName'))->render(), 'status' => 0]);
    }

    public function dynamicWorkingScheduleExportExcel($month)
    {
        return Excel::download(new \App\Exports\VacationExport(), 'vacation-' . date('d.m.Y') . '.xlsx');
    }

    public function update(Request $request)
    {
        $converted = str_pad($request->day, 2, '0', STR_PAD_LEFT);
        $dynamicWorkingSchedule = DynamicWorkingSchedule::where('user_id', $request->user_id)
            ->where('date', date($request->year.'-' . $request->month . '-' . $converted))
            ->updateOrCreate([
                'user_id' => $request->user_id,
                'date' => date($request->year.'-' . $request->month . '-' . $converted)
            ], ['dynamic_working_schedule_time_id' => $request->schedule_time]);
        return $dynamicWorkingSchedule;
    }
}
