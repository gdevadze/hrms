<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Movement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserMovementController extends Controller
{
    public function index(): View
    {
        return view('pages.user.movements');
    }

    public function getMovementsAjax(): JsonResponse
    {
        return Datatables()->of(Movement::query()->where('user_id',currentUser()->id)->latest())
            ->addIndexColumn()
            ->editColumn('formatted_start_date', function ($data) {
                if($data->checkUser($data->user['working_schedule']['week_days'])){
                    return '<span class="badge text-bg-success">'.$data->formatted_start_date.'</span>';
                }else{
                    return '<span class="badge text-bg-danger">'.$data->formatted_start_date.'</span>';
                }
            })
            ->editColumn('formatted_end_date', function ($data) {
                if($data->checkUser($data->user['working_schedule']['week_days'],true)){
                    return '<span class="badge text-bg-success">'.$data->formatted_end_date.'</span>';
                }else{
                    return '<span class="badge text-bg-danger">'.$data->formatted_end_date.'</span>';
                }
            })
            ->addColumn('formatted_delay_reason', function ($data) {
                if ($data->delay_reason){
                    return $data->delay_reason;
                }
                if(!$data->checkUser($data->user['working_schedule']['week_days'])){
                    return view('general.staff.delay_reason',compact('data'))->render();
                }
            })
            ->rawColumns(['formatted_end_date', 'formatted_start_date', 'formatted_delay_reason'])
            ->make(true);

    }

    public function saveDelayReason(Request $request,$id)
    {
        try {
            if(!$request->delay_reason){
                return jsonResponse(['status' => 1,'msg' => 'გთხოვთ მიუთითოთ დაგვიანების მიზეზი!']);
            }
            Movement::findOrFail($id)->update(['delay_reason' => $request->delay_reason]);
            return jsonResponse(['status' => 0,'msg' => 'დაგვიანების მიზეზი წარმატებით დაფიქსირდა!']);
        } catch (\Exception $exception){

        }
    }
}
