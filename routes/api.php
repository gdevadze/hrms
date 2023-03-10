<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/users', function (){
    $users = User::all(['name','card_number']);
    return jsonResponse($users,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
});

Route::get('date', function (Request $request){
    $movement = \App\Models\Movement::latest()->first();
    return jsonResponse(['status' => 0,'date' => $movement->start_date]);
});

Route::post('/logs', function (Request $request){
    $data = $request->all();
    foreach ($data as $json){
        $user = User::where('card_number',$json['card_id'])->latest()->first();
        $startDate = Carbon::parse($json['start_date'])->tz('Asia/Tbilisi');
        $endDate = null;
        if ($json['end_date']){
            $endDate = Carbon::parse($json['end_date'])->tz('Asia/Tbilisi');
        }

        \App\Models\Movement::where('start_date',$startDate)->updateOrCreate([
            'user_id' => $user->id,
            'card_number' => $json['card_id'],
            'start_date' => $startDate,
        ],['end_date' => $endDate]);
    }
    return jsonResponse($data,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
});
