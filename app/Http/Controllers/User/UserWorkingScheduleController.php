<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DynamicWorkingSchedule;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserWorkingScheduleController extends Controller
{
    public function index()
    {
        $workingSchedule = currentUser()->working_schedule;
        $dynamicWorkingSchedules = [];
        if (currentUser()->working_schedule_id == 2){
            $dynamicWorkingSchedules = DynamicWorkingSchedule::where('user_id',currentUser()->id)->get();
        }
        return view('pages.user.working_schedule',compact('workingSchedule','dynamicWorkingSchedules'));
    }
}
