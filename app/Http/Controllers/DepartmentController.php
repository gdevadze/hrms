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

    public function ajax(): JsonResponse
    {
        return Datatables()->of(Department::query())
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                $html = '';
                $html .= ' <a class="btn btn-soft-primary waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="PDF"  href="'.route('vacations.pdf',$data->id).'" target="_blank"><i class="fa fa-file-pdf-o"></i></a>';
                if ($data->status != 2){
                    $html .= ' <a class="btn btn-soft-success waves-effect waves-light" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('confirm').'" onclick="confirmHonorableReason('.$data->id.')" href="javascript:void(0)"><i class="fa fa-check"></i></a>';
                }
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
}
