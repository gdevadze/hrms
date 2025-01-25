<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Movement;
use App\Models\User;
use App\Models\UserCompany;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function movements(): View
    {
        return view('pages.reports.movements');
    }

    public function movementsAjax(Request $request): JsonResponse
    {
        $movements = Movement::query()->with('user');
        if(currentUser()->hasRole('Admin')){
            $movements = Movement::query()->with('user')->whereDate('start_date',Carbon::today())->whereIn('user_id',[175,174]);
        }
        if($request->start_date){
            $movements = $movements->whereDate('start_date','>=',$request->start_date);
        }
        if($request->end_date){
            $movements = $movements->whereDate('start_date','<=',$request->end_date);
        }
        return Datatables()->of($movements)
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
                $html .= ' <a class="btn btn-soft-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="რედაქტირება" href="' . route('reports.movements.edit', $data->id) . '"><i class="fa fa-edit"></i></a>';
                return $html;
            })
            ->rawColumns(['formatted_start_date', 'formatted_end_date', 'action'])
            ->make(true);

    }

    public function movementsExportExcel(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        return Excel::download(new \App\Exports\UserMovementsExport($startDate,$endDate), 'movements - ' . date('d.m.Y') . '.xlsx');
    }

    public function movementCreate(): View
    {
        $users = UserCompany::all();
        return view('pages.reports.movement_create',compact('users'));
    }

    public function movementStore(Request $request): RedirectResponse
    {
        $user = User::findOrFail($request->user_id);
        $data = $request->all();
        $data['card_number'] = $user->card_number;
        $movement = Movement::create($data);
        return redirect()->to(route('reports.movements.index'))->with('success','გატარება წარმატებით დაემატა!');
    }

    public function movementEdit($id): View
    {
        $movement = Movement::findOrFail($id);
        return view('pages.reports.movement_edit',compact('movement'));
    }

    public function movementUpdate(Request $request,$id): RedirectResponse
    {
        $movement = Movement::findOrFail($id)->update($request->except('new_start_date','new_end_date'));
        if($request->new_start_date){
            $user = User::findOrFail($request->user_id);
            $startDate = Carbon::parse($request->new_start_date)->format('Y-m-d H:i');
//            $startDate = Carbon::parse($request->start_date)->format('Y-m-d H:i');
            Movement::create([
                'user_id' => $user->id,
                'card_number' => $user->card_number,
                'start_date' => $startDate,
                'end_date' => $request->new_end_date,
            ]);
        }
        return redirect()->back();
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

    public function hrTable($type = 1): View
    {
        $companies = Company::all();
        return view('pages.reports.hr_table', compact('companies','type'));
    }

    public function hrTableAjax(Request $request): JsonResponse
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
        if ($request->type == 1){
            $users = UserCompany::where('company_id', $request->company_id)->where('status',1)->whereNotNull('working_schedule_id')->with('working_schedule')->get()
                ?->map?->getWorkedHoursByDay($year, $month);
        }else{
            $users = UserCompany::where('company_id', $request->company_id)->where('status',1)->whereNotNull('working_schedule_id')->with('working_schedule')->get()
                ?->map?->getWorkedHoursByDaySchedule($year, $month);
        }

        $company = Company::findOrFail($request->company_id);
        $date = Carbon::today()->format('d.m.Y');
        $startDate = Carbon::createFromFormat("Y-m-d", "{$year}-{$month}-01")->format('Y-m-d');
        $endDate = Carbon::createFromFormat("Y-m-d", "{$year}-{$month}-".$month_days)->format('Y-m-d');
        return jsonResponse(['html' => view('general.reports.hr_table', compact('month_days','users','company','date','startDate','endDate'))->render(), 'status' => 0]);
    }

    public function exportHrTable($id,$selectedDate,$type)
    {
        $company = Company::findOrFail($id);
        return Excel::download(new \App\Exports\TabelExport(1,$id,$selectedDate,$type), $company->title.' ('.$company->identification_code.')'.' - ' . date('d.m.Y') . '.xlsx');
    }

    public function exportWorkedHoursTable($id,$selectedDate,$type)
    {
        $company = Company::findOrFail($id);
        return Excel::download(new \App\Exports\TabelExport(2,$id,$selectedDate,$type), $company->title.' ('.$company->identification_code.')'.' - ' . date('d.m.Y') . '.xlsx');
    }

    public function workedHours($type = 1): View
    {
        $companies = Company::all();
        return view('pages.reports.worked_hours', compact('companies','type'));
    }

    public function dynamicShift(): View
    {
        $companies = Company::all();
        return view('pages.reports.dynamic_shift', compact('companies'));
    }

    public function dynamicShiftAjax(Request $request): JsonResponse
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
        $users = UserCompany::whereDate('contract_end_date','>=',Carbon::today())->orWhereNull('contract_end_date')->where('company_id', $request->company_id)->where('status',1)->whereNotNull('working_schedule_id')->where('working_schedule_id',2)
            ->get();
        $company = Company::findOrFail($request->company_id);
        $date = Carbon::today()->format('d.m.Y');
        return jsonResponse(['html' => view('general.reports.dynamic_shift', compact('month_days','users','company','date','year','month'))->render(), 'status' => 0]);
    }

    public function exportDynamicShift($id,$selectedDate)
    {
        $company = Company::findOrFail($id);
        return Excel::download(new \App\Exports\DynamicShiftExport($id,$selectedDate), $company->title.' ('.$company->identification_code.')'.' - ' . date('d.m.Y') . '.xlsx');
    }

    public function workedHoursAjax(Request $request)
    {
        if (!$request->company_id){
            return \jsonResponse(['status' => 2,'error' => 'გთხოვთ აირჩიოთ კომპანია!']);
        }
        $year = date('Y');
        $month = date('m');
        $type = $request->type;
        if($request->selected_date){
            $year = explode('.',$request->selected_date)[1];
            $month = explode('.',$request->selected_date)[0];
            $month = str_pad($month, 2, '0', STR_PAD_LEFT);
        }
        $month_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        if ($type == 1){
            $users = UserCompany::where('company_id', $request->company_id)->where('status',1)->whereNotNull('working_schedule_id')->with('working_schedule')->get()
                ?->map?->getWorkedHoursByDay($year,$month);
        }else{
            $users = UserCompany::where('company_id', $request->company_id)->where('status',1)->whereNotNull('working_schedule_id')->with('working_schedule')->get()
                ?->map?->getWorkedHoursByDaySchedule($year,$month);
        }
//        $users = User::where('company_id', $request->company_id)->where('status',1)->whereNotNull('working_schedule_id')->with('movements')->with('working_schedule')->get()
//            ?->map?->getWorkedHoursByDay1('2024', '09');
//        return $users;
        $company = Company::findOrFail($request->company_id);
        $date = Carbon::today()->format('d.m.Y');
        return jsonResponse(['html' => view('general.reports.worked_hours', compact('month_days','users','company','date','year','month','type'))->render(), 'status' => 0]);
    }
}
