<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserMovementController;
use App\Http\Controllers\Api\UserVacationController;
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

Route::get('test', function(){
    return view('html');
});

Route::post('/upload_image', function(Request $request){
    $file = $request->file('file');
    // return $file;
    // Check if the file is valid
    // if ($file->isValid()) {
        // Generate a unique name for the file
        $fileName = uniqid('image_') . '.jpg';

        // Move the file to the desired directory
        $file->storeAs('images', $fileName, 'public');

        // Optionally, you can save the file path to the database or perform other actions
        $filePath = 'storage/images/' . $fileName;

        // Return a response or do other things as needed
        return response()->json(['message' => 'Image uploaded successfully', 'file_path' => $filePath]);
    // } else {
    //     // Handle invalid file
    //     return response()->json(['error' => 'Invalid file'], 400);
    // }
});

Route::post('/fortigate', function(Request $request){
    info($request->all());
});

Route::name('api.')->group(function() {
    Route::post('/login', [AuthController::class,'login_token'])->name('login');


    Route::middleware('auth:sanctum')->group(function() {

        // Get current user
        Route::get('/user', function (Request $request) {
            return $request->user();
        })->name('current_user');


        // User logout
        Route::post('/logout', [AuthController::class,'logout_token'])->name('logout');
        Route::get('/dashboard',[\App\Http\Controllers\Api\DashboardController::class,'index']);
        Route::get('/movements',[UserMovementController::class,'index']);
        Route::get('/vacations',[UserVacationController::class,'index']);
        Route::post('/user_movement_action',[\App\Http\Controllers\Api\DashboardController::class,'userMovementAction']);
        Route::post('/password_change',[AuthController::class,'changePassword']);
    });
});


//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/users', function (){
    $users = User::all(['name_en','card_number']);
    return jsonResponse($users,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
});

Route::get('date', function (Request $request){
    $movement = \App\Models\Movement::latest()->first();
    return jsonResponse(['status' => 0,'date' => Carbon::parse($movement->start_date)->format('Y-m-d')]);
});

Route::get('/reminder_office_leave',function (\App\Services\HonorableReasonService $honorableReasonService,\App\Services\MessageService $messageService){
    $movements = \App\Models\Movement::whereNotIn('working_schedule_id',[2])->where('user_id',1)->whereDate('start_date',date('Y-m-d'))->whereNull('end_date')->get();
    foreach ($movements as $movement){
        $date = $honorableReasonService->getCurrectWorkingDayEndDate($movement->user->working_schedule->week_days);
        return Carbon::parse($date)->diffInMinutes(Carbon::now()->format('H:i'));
        if(Carbon::parse($date)->diffInMinutes(Carbon::now()->format('H:i')) < 15){
            $text = $movement->user->full_name.', გთხოვ არ დაგავიწყდეს სამსახურიდან გასვლის დაფიქსირება';
            $messageService->sms($movement->user->tel,$text);
            echo $movement->user->full_name.' - '.$date.'<br>';
        }else{
            echo $movement->user->full_name.' - '.$date.'<br>';
        }
    }
//    return $movements;

});

Route::get('/missings', function (\App\Services\HonorableReasonService $honorableReasonService,\App\Services\MessageService $messageService){
    $users = User::whereNotIn('id',[16])->where('company_id',1)->where('working_schedule_id',1)->get();
    return $users;
    foreach ($users as $user){
        if($honorableReasonService->getCurrectWorkingDay($user->working_schedule->week_days)){
            $movement = \App\Models\Movement::where('user_id',$user->id)->whereDate('start_date',Carbon::today())->first();
//            return $user->id;
            if(!$movement){
                $messageService->sms($user->tel,$user->name_ka.', გთხოვთ დააფიქსიროთ სამსახურში გამოცხადება!');
            }
        }
    }
});

Route::post('/logs', function (Request $request){
    $data = $request->all();
    foreach ($data as $json){
        $user = User::where('card_number',$json['card_id'])->latest()->first();
        $startDate = Carbon::parse($json['start_date'])->tz('Asia/Tbilisi');
        $movement = \App\Models\Movement::whereDate('start_date',$startDate->format('Y-m-d'))->where('user_id',$user->id)->first();
        $endDate = $movement->end_date ?? null;
        if ($json['end_date']){
            $endDate = Carbon::parse($json['end_date'])->tz('Asia/Tbilisi');
        }
        // if(!$movement){
            \App\Models\Movement::where('start_date',$startDate)->updateOrCreate([
                'user_id' => $user->id,
                'card_number' => $json['card_id'],
                'start_date' => $startDate,
            ],['end_date' => $endDate]);
        // }
    }
    return jsonResponse($data,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
});
