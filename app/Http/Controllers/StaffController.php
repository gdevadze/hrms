<?php

namespace App\Http\Controllers;

use App\Enums\WeekDays;
use App\Models\DynamicWorkingSchedule;
use App\Models\Movement;
use App\Models\Position;
use App\Models\User;
use App\Services\Contracts\WorkSchedulingServiceContract;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use PDF;

class StaffController extends Controller
{
    private WorkSchedulingServiceContract $workSchedulingService;

    public function __construct(WorkSchedulingServiceContract $workSchedulingService)
    {
        $this->workSchedulingService = $workSchedulingService;
    }


    public function renderStaffInfo(Request $request)
    {
        $month = date('m');
        $year = date('Y');
        $this->workSchedulingService->init($request->user_id,$month,$year);
        $workingAndMissedDays = $this->workSchedulingService->calculateEmployeeWorkingAndMissedDays();
        $totalWorkingTime = $this->workSchedulingService->calculateTotalWorkingTime();
        $employeeLateIncomes = $this->workSchedulingService->calculateEmployeeLateIncomes();
        $employeeGoEarly = $this->workSchedulingService->calculateEmployeeGoEarly();
        $user = $this->workSchedulingService->getUser();
        $movements = $this->workSchedulingService->fetchUserMovements();

        $userVacation = $user->user_vacation_quantities()->sum('quantity');
        $usedUserVacations = $user->user_vacation_quantities()->sum('current_quantity');

        return jsonResponse([
            'html' => view('general.staff.info', compact('user', 'movements','workingAndMissedDays','totalWorkingTime','employeeLateIncomes','employeeGoEarly','userVacation','usedUserVacations'))->render(),
            'status' => 0]);
    }

    public function getMovementsPdf($id)
    {
        $month = date('m');
        $year = date('Y');
        $this->workSchedulingService->init($id,$month,$year);
        $workingAndMissedDays = $this->workSchedulingService->calculateEmployeeWorkingAndMissedDays();
        $totalWorkingTime = $this->workSchedulingService->calculateTotalWorkingTime();
        $employeeLateIncomes = $this->workSchedulingService->calculateEmployeeLateIncomes();
        $employeeGoEarly = $this->workSchedulingService->calculateEmployeeGoEarly();
        $user = $this->workSchedulingService->getUser();

        $pdf = PDF::loadView('exports.movements_pdf', compact('user', 'workingAndMissedDays','totalWorkingTime','employeeLateIncomes','employeeGoEarly'));

        return $pdf->stream('Report - '.$user->personal_num.'.pdf');
    }

    public function userMovementAction()
    {
        $whitelist = file_get_contents(public_path('whitelist.json'));
        $jsonArr = json_decode($whitelist, true);
        $ipCollection = collect($jsonArr)->pluck('ip')->toArray();
        $userIp = \request()->ip();
        if(!in_array($userIp, $ipCollection)){
            return redirect()->back()->with('error','თქვენი IP მისამართი ('.$userIp.') არ იმყოფება აღრიცხვის ოფისში!');
        }
        $movement = Movement::where('user_id',currentUser()->id)->whereDate('start_date', Carbon::today())->first();
        if (isset($movement)){
            $movement->update(['end_date' => Carbon::now()]);
            $responseText = 'სამუშაოს დასრულება წარმატებით დაფიქსირდა!';
        }else{
            $dynamicWorkingScheduleId = null;
            if(currentUser()->working_schedule_id == 2){
                $dynamicWorkingSchedule = DynamicWorkingSchedule::where('user_id',currentUser()->id)->where('date',date('Y-m-d'))->first();
                $dynamicWorkingScheduleId = $dynamicWorkingSchedule->id;
            }
            Movement::create([
                'user_id' => currentUser()->id,
                'working_schedule_id' => currentUser()->working_schedule_id,
                'dynamic_working_schedule_id' => $dynamicWorkingScheduleId,
                'card_number' => currentUser()->card_number,
                'start_date' => Carbon::now()
            ]);
            $responseText = 'სამსახურში გამოცხადება წარმატებით დაფიქსირდა!';
        }
        return redirect()->back()->with('success',$responseText);
    }
}
