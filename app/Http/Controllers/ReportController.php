<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Movement;
use App\Models\User;
use App\Models\UserCompany;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function movements(): View
    {
        return view('pages.reports.movements');
    }

    public function movementsAjax(): JsonResponse
    {
        return Datatables()->of(Movement::query()->with('user'))
            ->addIndexColumn()
            ->editColumn('formatted_start_date', function ($data) {
                if ($data->checkUser($data->user['working_schedule']['week_days'])) {
                    return '<span class="badge text-bg-success">' . $data->formatted_start_date . '</span>';
                } else {
                    return '<span class="badge text-bg-danger">' . $data->formatted_start_date . '</span>';
                }
            })
            ->editColumn('formatted_end_date', function ($data) {
                if ($data->checkUser($data->user['working_schedule']['week_days'], true)) {
                    return '<span class="badge text-bg-success">' . $data->formatted_end_date . '</span>';
                } else {
                    return '<span class="badge text-bg-danger">' . $data->formatted_end_date . '</span>';
                }
            })
            ->addColumn('action', function ($data) {
                $html = '';
                $html .= ' <a class="btn btn-soft-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="PDF"  href="' . route('vacations.pdf', $data->id) . '" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                if ($data->status != 2) {
                    $html .= ' <a class="btn btn-soft-success waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('confirm') . '" onclick="confirmHonorableReason(' . $data->id . ')" href="javascript:void(0)"><i class="fa fa-check"></i></a>';
                }
                return $html;
            })
            ->rawColumns(['formatted_start_date', 'formatted_end_date', 'action'])
            ->make(true);

    }

    public function rs(): View
    {
        $companies = Company::all();
        return view('pages.reports.rs', compact('companies'));
    }

    public function rsAjax(Request $request): JsonResponse
    {
        return Datatables()->of(User::where('company_id', $request->company_id)->get())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $html = '';
                $html .= ' <a class="btn btn-soft-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="PDF"  href="' . route('vacations.pdf', $data->id) . '" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                if ($data->status != 2) {
                    $html .= ' <a class="btn btn-soft-success waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="' . __('confirm') . '" onclick="confirmHonorableReason(' . $data->id . ')" href="javascript:void(0)"><i class="fa fa-check"></i></a>';
                }
                return $html;
            })
            ->rawColumns(['formatted_start_date', 'formatted_end_date', 'action'])
            ->make(true);

    }

    public function hrTable(): View
    {
        $companies = Company::all();
        return view('pages.reports.hr_table', compact('companies'));
    }

    public function hrTableAjax(Request $request)
    {
        if (!$request->company_id){
            return \jsonResponse(['status' => 2,'error' => 'გთხოვთ აირჩიოთ კომპანია!']);
        }
        $year = date('Y');
        $month = date('m');
        if($request->selected_date){
            $year = explode('.',$request->selected_date)[1];
            $month = explode('.',$request->selected_date)[0];
            $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        }
        $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $users = UserCompany::where('company_id', $request->company_id)->where('status',1)->whereNotNull('working_schedule_id')->with('working_schedule')->get()
            ?->map?->getWorkedHoursByDay($year, $month);
        $company = Company::findOrFail($request->company_id);
        $date = Carbon::today()->format('d.m.Y');
        return jsonResponse(['html' => view('general.reports.hr_table', compact('month_days','users','company','date'))->render(), 'status' => 0]);
    }

    public function exportHrTable($id,$selectedDate)
    {
        $company = Company::findOrFail($id);
        return Excel::download(new \App\Exports\TabelExport($id,$selectedDate), $company->title.' - ' . date('d.m.Y') . '.xlsx');
    }

    public function workedHours(): View
    {
        $companies = Company::all();
        return view('pages.reports.worked_hours', compact('companies'));
    }

    public function workedHoursAjax(Request $request)
    {
        if (!$request->company_id){
            return \jsonResponse(['status' => 2,'error' => 'გთხოვთ აირჩიოთ კომპანია!']);
        }
        $month_days = cal_days_in_month(CAL_GREGORIAN, 1, 2024);
        $users = User::where('company_id', $request->company_id)->where('status',1)->whereNotNull('working_schedule_id')->with('movements')->with('working_schedule')->get()
            ?->map?->getWorkedHoursByDay('2024', '1');
//        return $users;
        $company = Company::findOrFail($request->company_id);
        $date = Carbon::today()->format('d.m.Y');
        return jsonResponse(['html' => view('general.reports.worked_hours', compact('month_days','users','company','date'))->render(), 'status' => 0]);
    }
}
