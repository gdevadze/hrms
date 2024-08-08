<?php

namespace App\Http\Controllers;

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
        $users = User::role(3)->get();
        return jsonResponse(['status' => 0,'title' => 'პოზიციის დამატება','html' =>view('general.positions.create',compact('users'))->render()]);
    }

    public function ajax(): JsonResponse
    {
        return Datatables()->of(Position::query())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $html = '';
                $html .= ' <a class="btn btn-primary shadow btn-xs sharp mr-1 edit-position" data-id="'.$data->id.'" href="javascript:void(0)"><i class="fa fa-edit"></i></a>';
                return $html;
            })
            ->rawColumns(['role', 'action', 'formatted_status'])
            ->make(true);

    }

    public function store(Request $request): JsonResponse
    {
        Position::create([
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
        $users = User::role(3)->get();
        return jsonResponse(['status' => 0,'html' => view('general.positions.edit',compact('position','users'))->render()]);
    }

    public function update(Request $request,$id): JsonResponse
    {
        Position::findOrFail($id)->update([
            'title' => $request->title,
            'manager_id' => $request->manager_id,
            'helper_manager_id' => $request->helper_manager_id,
            'helper_id' => $request->helper_id,
        ]);

        return jsonResponse(['status' => 0,'msg' => 'პოზიცია წარმატებით ჩასწორდა!']);
    }
}
