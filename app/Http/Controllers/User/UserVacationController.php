<?php

namespace App\Http\Controllers\User;

use App\Enums\VacationType;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreHonorableReason;
use App\Http\Requests\UserStoreHonorableReasonRequest;
use App\Models\User;
use App\Models\Vacation;
use App\Services\MessageService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserVacationController extends Controller
{
    public function index(): View
    {
        $userVacation = currentUser()->user_vacation_quantities()->sum('quantity');
        $usedUserVacations = currentUser()->user_vacation_quantities()->sum('current_quantity');
        $vacationDays = $userVacation - $usedUserVacations;
        return view('pages.user.vacations.index',compact('vacationDays'));
    }

    public function getHonorableReasonsAjax(): JsonResponse
    {
        return Datatables()->of(Vacation::query()->where('user_id',currentUser()->id))
            ->addIndexColumn()
            ->addColumn('formatted_status', function ($data) {
                if ($data->status == 1){
                    return '<i style="color: green;font-size: 21px" data-bs-toggle="tooltip" data-bs-placement="top" title="მოლოდინის რეჟიმში" class="ri-loader-2-fill"></i>';
                }
                if ($data->status == 2){
                    return '<i style="color: green;font-size: 21px" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('confirmed').'" class="ri-check-line"></i>';
                }
                return '<i style="color: red;font-size: 21px" class="ri-close-line"></i>';
            })
            ->rawColumns(['role', 'action', 'formatted_status'])
            ->make(true);

    }

    public function createRender(): JsonResponse
    {
        return jsonResponse(['status' => 0,'html' => view('general.vacations.user.create')->render()]);
    }

    public function store(UserStoreHonorableReasonRequest $request,MessageService $messageService): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = currentUser()->id;
        $data['reason_type'] = VacationType::PAID_LEAVE;
        $data['working_schedule_id'] = currentUser()->working_schedule_id;
        $honorableReasonCheck = Vacation::where('start_date', '<=',Carbon::parse($data['start_date'])->format('Y-m-d'))
            ->where('end_date', '>=',Carbon::parse($data['end_date'])->format('Y-m-d'))
            ->where('reason_type',$data['reason_type'])
            ->where('user_id', $data['user_id'])
            ->first();
        if($honorableReasonCheck){
            return jsonResponse(['status' => 1,'msg' => __('leave_has_already_been_dates')]);
        }
        $vacation = Vacation::create($data);
        $user = $vacation->user;
        $text = "შვებულების მოთხოვნა <br> თანამშრომელი: $user->full_name <br> თარიღი: $vacation->honorable_reason_dates";
        $textEn = "Leave request <br> Employee: $user->full_name <br> Date: $vacation->honorable_reason_dates";
        $messageService->email('giorgi.devadze@asyasoftware.ge',$textEn);
        // if(currentUser()->manager_id){
        //     $manager = User::findOrFail(currentUser()->manager_id);
        //     $messageService->email($manager->email,$text);
        // }
        return jsonResponse(['status' => 0,'msg' => __('your_leave_successfully_requested_wait_response')]);
    }
}
