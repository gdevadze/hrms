<?php

namespace App\Http\Controllers;

use App\Models\DynamicWorkingScheduleTime;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DynamicWorkingScheduleTimeController extends Controller
{
    public function index(): View
    {
        return view('pages.working_schedule.dynamic_working_time');
    }

    public function dynamicWorkingScheduleTimeAjax()
    {
        return Datatables()->of(DynamicWorkingScheduleTime::whereNotIn('id',[1])->latest()->get())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $html = ' <a class="btn btn-soft-secondary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('edit').'" href="'.route('dynamic.working.schedule.time.edit',$data->id).'"><i class="fa fa-pencil"></i></a>';
                return $html;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(): View
    {
        return view('pages.working_schedule.dynamic_working_time_create');
    }

    public function edit($id): View
    {
        $dynamicWorkingScheduleTime = DynamicWorkingScheduleTime::findOrFail($id);
        return view('pages.working_schedule.dynamic_working_time_edit',compact('dynamicWorkingScheduleTime'));
    }

    public function store(Request $request): RedirectResponse
    {
        DynamicWorkingScheduleTime::create($request->all());
        return redirect()->route('dynamic.working.schedule.time.index')->with('success','ინფორმაცია წარმატებით დაემატა!');
    }

    public function update(Request $request,$id): RedirectResponse
    {
        DynamicWorkingScheduleTime::findOrFail($id)->update($request->all());
        return redirect()->route('dynamic.working.schedule.time.index')->with('success','ინფორმაცია წარმატებით განახლდა!');
    }
}
