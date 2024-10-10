<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\DynamicWorkingSchedule;
use App\Models\DynamicWorkingScheduleTime;
use App\Models\Position;
use App\Models\User;
use App\Models\UserCompany;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Mpdf\Tag\P;

class DynamicWorkingScheduleController extends Controller
{
    public function index(): View
    {
        $companies = Company::all();
        $positions = Position::all();
        return view('pages.working_schedule.dynamic_working_schedule', compact('companies','positions'));
    }

    public function ajax(Request $request)
    {
        if (!$request->company_id) {
            return jsonResponse(['status' => 2,'error' => 'გთხოვთ აირჩიოთ კომპანია!']);
        }

        $companyId = $request->company_id;
        $positionId = $request->position_id;
        $startDate = $request->start_date ?? date('Y-m-01');
        $endDate = $request->end_date ?? date('Y-m-t');

        $start = Carbon::createFromFormat('Y-m-d', $startDate);
        $end = Carbon::createFromFormat('Y-m-d', $endDate);

        $users = UserCompany::with(['user', 'dynamic_working_schedule' => function ($query) use ($start, $end) {
            $query->where('date','>=',$start->format('Y-m-d'))->where('date','<=',$end->format('Y-m-d'));
        }])
            ->where('working_schedule_id', 2)
            ->where('company_id', $companyId)
            ->when(!empty($positionId), function($query) use ($positionId){
                return $query->where('position_id', $positionId);
            })
            ->where('status', 1)
            ->get();

        $daysInRange = $start->diffInDays($end) + 1;
        $dynamicWorkingScheduleTime = DynamicWorkingScheduleTime::all();

        return jsonResponse([
            'html' => view('general.working_schedule.dynamic_working_schedule', compact(
                'users', 'start', 'end', 'daysInRange', 'dynamicWorkingScheduleTime'
            ))->render(),
            'status' => 0
        ]);
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

    public function workingScheduleTimeListRender(Request $request): JsonResponse
    {
        $workingScheduleTimes = DynamicWorkingScheduleTime::all();
        $date = $request->date;
        $formattedDate = Carbon::parse($date)->format('d.m.Y');
        return jsonResponse([
            'html' => view('general.working_schedule.dynamic_working_schedule_time_list', compact(
                'workingScheduleTimes','formattedDate', 'date'
            ))->render(),
            'status' => 0
        ]);
    }

    public function workingScheduleSetTimeUsers(Request $request)
    {
        $users = UserCompany::where('company_id',$request->company_id);
        if($request->position_id){
            $users = $users->where('position_id',$request->position_id);
        }
        $users = $users->get();
        foreach ($users as $user){
            DynamicWorkingSchedule::where('user_id', $user->user_id)
                ->where('date', $request->date)
                ->updateOrCreate([
                    'user_id' => $user->user_id,
                    'date' => $request->date
                ], ['dynamic_working_schedule_time_id' => $request->dynamic_working_schedule_id]);
        }
        return jsonResponse(['status' => 0,'msg' => 'გრაფიკი წარმატებით ჩასწორდა!']);
    }
}
