<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHolidayRequest;
use App\Models\Holiday;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {

        return view('pages.holidays');
    }

    public function ajax()
    {
        $yearHolidays = Holiday::orderBy('year','desc')->get()->groupBy('year');
        return jsonResponse(['html' => view('general.holidays.index',compact('yearHolidays'))->render(),'status' => 0]);
    }

    public function store(StoreHolidayRequest $request): \Illuminate\Http\JsonResponse
    {
        $date = Carbon::parse($request->date)->format('Y-m-d');
        Holiday::create([
            'title' => $request->title,
            'date' => $date,
            'year' => date('Y')
        ]);

        return jsonResponse(['status' => 1]);
    }
}
