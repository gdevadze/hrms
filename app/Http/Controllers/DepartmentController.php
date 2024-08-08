<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(): View
    {
        return view('pages.settings.departments.index');
    }

    public function create(): JsonResponse
    {
        return jsonResponse(['status' => 0,'title' => 'დეპარტამენტის დამატება','html' =>view('general.departments.create')->render()]);
    }

    public function edit(Request $request): JsonResponse
    {
        $department = Department::findOrFail($request->id);
        return jsonResponse(['status' => 0,'title' => 'დეპარტამენტის რედაქტირება','html' =>view('general.departments.edit',compact('department'))->render()]);
    }

    public function ajax(): JsonResponse
    {
        return Datatables()->of(Department::query())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $html = '';
                $html .= ' <a class="btn btn-soft-primary waves-effect waves-light edit_department" data-bs-toggle="tooltip" data-id="'.$data->id.'" data-bs-placement="top" title="რედაქტირება"  href="javascript:void(0)"><i class="fa fa-edit"></i></a>';

                return $html;
            })
            ->rawColumns(['role', 'action', 'formatted_status'])
            ->make(true);

    }

    public function store(Request $request): JsonResponse
    {
        Department::create([
            'title' => $request->title,
        ]);

        return jsonResponse(['status' => 0,'msg' => 'დეპარტამენტი წარმატებით დაემატა!']);
    }

    public function update(Request $request,$id): JsonResponse
    {
        Department::findOrfail($id)->update([
            'title' => $request->title,
        ]);

        return jsonResponse(['status' => 0,'msg' => 'დეპარტამენტი წარმატებით განახლდა!']);
    }
}
