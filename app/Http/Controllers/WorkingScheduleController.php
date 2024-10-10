<?php

namespace App\Http\Controllers;

use App\Enums\WeekDays;
use App\Models\WorkingSchedule;
use Illuminate\Http\Request;

class WorkingScheduleController extends Controller
{
    public function index()
    {
        return view('pages.working_schedule.index');
    }

    public function create()
    {
        $weekDays = WeekDays::all();
        return view('pages.working_schedule.create', compact('weekDays'));
    }

    public function store(Request $request)
    {
        $weekDays = $request->week_days;
        $startTimes = $request->start_time;
        $endTimes = $request->end_time;
        $breakDurations = $request->break_duration;

        $result = [];
        foreach ($weekDays as $key=> $day) {
            if (!isset($startTimes[$key]) || !isset($endTimes[$key])) {
                continue;
            }
            $result[$day] = [
                'start_time' => $startTimes[$key],
                'end_time' => $endTimes[$key],
                'break_duration' => $breakDurations[$key]
            ];
        }
        if (!count($result)){
            return jsonResponse(['status' => 2]);
        }
        WorkingSchedule::create([
            'title' => $request->title,
            'week_days' => $result
        ]);
        return redirect(route('working.schedule.index'))->with('success',__('information_added_successfully'));
    }

    public function edit($id)
    {
        $weekDays = WeekDays::all();
        $workingSchedule = WorkingSchedule::findOrFail($id);

        $gio = $workingSchedule->week_days;
        $resolvedWeekDays = collect($weekDays)->map(function ($item) use($gio) {
            $times = $gio[$item['key']] ?? null;
            if ($times != null) {
                $item['times'] = $times;
            }
            return $item;
        });
        return view('pages.working_schedule.edit',compact('workingSchedule','resolvedWeekDays'));
    }

    public function update(Request $request, $id)
    {
        $weekDays = $request->week_days;
        $startTimes = $request->start_time;
        $endTimes = $request->end_time;
        $breakDurations = $request->break_duration;

        $result = [];
        foreach ($weekDays as $key=> $day) {
            if (!isset($startTimes[$key]) || !isset($endTimes[$key])) {
                continue;
            }
            $result[$day] = [
                'start_time' => $startTimes[$key],
                'end_time' => $endTimes[$key],
                'break_duration' => $breakDurations[$key]
            ];
        }
        if (!count($result)){
            return jsonResponse(['status' => 2]);
        }

        WorkingSchedule::findOrFail($id)->update([
            'title' => $request->title,
            'week_days' => $result
        ]);

        return redirect(route('working.schedule.index'))->with('success',__('information_updated_successfully'));
    }

    public function workingScheduleAjax()
    {
        return Datatables()->of(WorkingSchedule::whereNotIn('id',[2])->latest()->get())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('edit').'" href="'.route('working.schedule.edit',$data->id).'"><i class="fa fa-pencil"></i></a>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
