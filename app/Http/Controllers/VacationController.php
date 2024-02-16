<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use App\Services\HonorableReasonService;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use PDF;

class VacationController extends Controller
{
    public function index(): View
    {
        return view('pages.vacations.index');
    }

    public function getHonorableReasonsAjax(): JsonResponse
    {
        return Datatables()->of(Vacation::query()->with('user'))
            ->addIndexColumn()
            ->addColumn('formatted_status', function ($data) {
                if ($data->status == 1){
                    return '<i style="color: green;font-size: 21px" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('pending').'" class="ri-loader-2-fill"></i>';
                }
                if ($data->status == 2){
                    return '<i style="color: green;font-size: 21px" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('confirmed').'" class="ri-check-line"></i>';
                }
                return '<i style="color: red;font-size: 21px" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('rejected').'" class="ri-close-line"></i>';
            })
            ->addColumn('action', function ($data) {
                $html = '';
                $html .= ' <a class="btn btn-soft-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="PDF"  href="'.route('vacations.pdf',$data->id).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                if ($data->status != 0 && $data->status != 2){
                    $html .= ' <a class="btn btn-soft-success waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('confirm').'" onclick="confirmHonorableReason('.$data->id.')" href="javascript:void(0)"><i class="fa fa-check"></i></a>';
                }
                if ($data->status != 0 && $data->status != 2){
                    $html .= ' <a class="btn btn-soft-danger waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('reject').'" onclick="rejectVacation('.$data->id.')" href="javascript:void(0)"><i class="fa fa-close"></i></a>';
                }
                return $html;
            })
            ->rawColumns(['role', 'action', 'formatted_status'])
            ->make(true);

    }

    public function createRender(): JsonResponse
    {
        return jsonResponse(['status' => 0,'html' => view('general.vacations.create')->render()]);
    }

    public function confirmVacation(Request $request,MessageService $messageService,HonorableReasonService $honorableReasonService): JsonResponse
    {
        $vacation = Vacation::findOrFail($request->id);
        $scheduleJson = $vacation->working_schedule?->week_days;
        $text = 'თქვენი მოთხოვნა შვებულებასთან დაკავშირებით დაკმაყოფილებულია, თარიღები ('.$vacation->honorable_reason_dates.')';
//        $messageService->email($vacation->user->email,$text);
        $vacation->update(['status' => 2]);
        $diffDays = $honorableReasonService->countVacationDays($vacation->user_id,$vacation->start_date,$vacation->end_date, $vacation->working_schedule_id,$scheduleJson);;
        $currentVacationDays = $vacation->user->user_vacation_quantities()->where('current_quantity','>',0)->orderBy('year','ASC')->first()->current_quantity;
        $vacation->user->user_vacation_quantities()->where('current_quantity','>',0)->orderBy('year','ASC')->first()->update(['current_quantity' => $currentVacationDays + $diffDays]);
        return jsonResponse(['status' => 1]);
    }

    public function rejectVacation(Request $request,MessageService $messageService): JsonResponse
    {
        $vacation = Vacation::findOrFail($request->id);
        $text = 'თქვენი მოთხოვნა შვებულებასთან დაკავშირებით ('.$vacation->honorable_reason_dates.') უარყოფილია.';
        if($vacation->user->email){
            $messageService->email($vacation->user->email,$text);
        }
        $vacation->update(['status' => 0]);
        return jsonResponse(['status' => 1]);
    }

    public function pdf(HonorableReasonService $honorableReasonService,$id)
    {
        $vacation = Vacation::findOrFail($id);
        $scheduleJson = $vacation->working_schedule?->week_days;
        $vacationDays = $honorableReasonService->countVacationDays($vacation->user_id,$vacation->start_date,$vacation->end_date, $vacation->working_schedule_id,$scheduleJson);
        $nextWorkingDay = $honorableReasonService->getNextWorkingDate($vacation->user_id,$vacation->working_schedule_id,$vacation->end_date,$scheduleJson);
        $pdf = PDF::loadView('exports.vacation_pdf', compact('vacation','nextWorkingDay','vacationDays'));

        return $pdf->stream('შვებულების ფორმა - '.$vacation->user->personal_num.'.pdf');
    }
}
