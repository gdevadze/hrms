<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Position;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PositionController extends Controller
{
    public function index(): View
    {
        return view('pages.settings.positions.index');
    }

    public function create(): JsonResponse
    {
        $departments = Department::all();
        $users = User::role(3)->get();
        return jsonResponse(['status' => 0,'title' => 'პოზიციის დამატება','html' =>view('general.positions.create',compact('users','departments'))->render()]);
    }

    public function ajax(): JsonResponse
    {
        return Datatables()->of(Position::query())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $html = '';
                $html .= ' <a class="btn btn-primary shadow btn-xs sharp mr-1 edit-position" data-id="'.$data->id.'" href="javascript:void(0)"><i class="fa fa-edit"></i></a>';
                if ($data->user_companies()->count() == 0){
                    $html .= ' <a class="btn btn-danger shadow btn-xs sharp mr-1" onclick="deletePosition('.$data->id.')" href="javascript:void(0)"><i class="fa fa-trash"></i></a>';
                }
                return $html;
            })
            ->rawColumns(['role', 'action', 'formatted_status'])
            ->make(true);

    }

    public function store(Request $request): JsonResponse
    {
        Position::create([
            'department_id' => $request->department_id,
            'title' => $request->title,
            'manager_id' => $request->manager_id,
            'helper_manager_id' => $request->helper_manager_id,
            'helper_id' => $request->helper_id,
        ]);

        return jsonResponse(['status' => 0,'msg' => 'პოზიცია წარმატებით დაემატა!']);
    }

    public function edit(Request $request)
    {
        $position = Position::findOrFail($request->id);
        $departments = Department::all();
        $users = User::role(3)->get();
        return jsonResponse(['status' => 0,'html' => view('general.positions.edit',compact('position','users','departments'))->render()]);
    }

    public function update(Request $request,$id): JsonResponse
    {
        Position::findOrFail($id)->update([
            'department_id' => $request->department_id,
            'title' => $request->title,
            'manager_id' => $request->manager_id,
            'helper_manager_id' => $request->helper_manager_id,
            'helper_id' => $request->helper_id,
        ]);

        return jsonResponse(['status' => 0,'msg' => 'პოზიცია წარმატებით ჩასწორდა!']);
    }

    public function deletePosition(Request $request)
    {
        try {
            $position = Position::findOrFail($request->id);
            if($position->user_companies()->count() > 0){
                return jsonResponse(['status' => 2]);
            }
            $position->delete();
            return jsonResponse(['status' => 1]);
        } catch (\Exception $exception) {
            return jsonResponse(['status' => 0]);
        }
    }
}
