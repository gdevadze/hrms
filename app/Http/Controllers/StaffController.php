<?php

namespace App\Http\Controllers;

use App\Enums\WeekDays;
use App\Models\User;
use App\Services\Contracts\WorkSchedulingServiceContract;
use Illuminate\Http\Request;

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
        return jsonResponse(['html' => view('general.staff.info', compact('user', 'workingAndMissedDays','totalWorkingTime','employeeLateIncomes','employeeGoEarly'))->render(), 'status' => 0]);
    }
}
