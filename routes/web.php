<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DynamicWorkingScheduleController;
use App\Http\Controllers\DynamicWorkingScheduleTimeController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\User\UserWorkingScheduleController;
use App\Http\Controllers\VacationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\User\UserVacationController;
use App\Http\Controllers\User\UserMovementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingScheduleController;
use App\Models\Company;
use App\Models\User;
use App\Models\UserVacationQuantity;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Laradevsbd\Zkteco\Http\Library\ZktecoLib;
use Maatwebsite\Excel\Facades\Excel;
use Rats\Zkteco\Lib\ZKTeco;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/zktec', function (){
    $users = User::whereIn('personal_num',['61009030824',
'35001062506',
'61001075689',
'61001025509',
'61010019372',
'35001038605',
'61001041807',
'61001051365',
'61001086983',
'61008018895',
'61008013239',
'02001025637',
'61001056461',
'61002015953',
'61006020092',
'61006034941',
'61002016140',
'61008005924',
'61008013463',
'61001048310',
'61008013025',
'61005003821',
'61008007005',
'61008014892',
'5991000168',
'A18699081',
'FP5374549',
'A28682428',
'61191003677',
'C4YO83MLF',
])->get();
    return \App\Models\Movement::whereYear('start_date',2025)->whereMonth('start_date',01)->whereNotIn('user_id',$users->pluck('id')->all())->get();

    return $users;
});

Route::get('/testunia', function (App\Services\MessageService $messageService){

    $user = "root";
    $token = "VSWHKBCSV6JM2U83T0YQSTDNJGMX4M1J";

//    $query = "https://vmi1689824.contaboserver.net:2087/json-api/createacct?api.version=1&username=username&domain=example1.com";
//    $query = "https://vmi1689824.contaboserver.net:2087/json-api/listaccts?api.version=1";
//    $query = "https://vmi1689824.contaboserver.net:2087/json-api/suspendacct?api.version=1&user=phpweb";
    $query = "https://vmi1689824.contaboserver.net:2087/json-api/unsuspendacct?api.version=1&user=phpweb";
    $query = "https://s1.phpweb.ge:2087/json-api/create_user_session?api.version=1&user=phpweb&service=cpaneld";
    $query = "https://s1.phpweb.ge:2087/json-api/getzonerecord?api.version=1&domain=phpweb.ge&line=4";

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER,1);

    $header[0] = "Authorization: whm $user:$token";
    curl_setopt($curl,CURLOPT_HTTPHEADER,$header);
    curl_setopt($curl, CURLOPT_URL, $query);

    $result = curl_exec($curl);

    $http_status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    if ($http_status != 200) {
        echo "[!] Error: " . $http_status . " returned\n";
    } else {
        $json = json_decode($result);
        return $json;
        echo "[+] Current cPanel users on the system:\n";
        foreach ($json->{'data'}->{'acct'} as $userdetails) {
            echo "\t" . $userdetails->user .' - '. $userdetails->domain . "\n";
        }
    }

    curl_close($curl);

//    $ip = \request()->ip();
//    // return $ip;
//    $response = Http::get("http://www.geoplugin.net/json.gp?ip=" . $ip);
//
//    // Check if the request was successful
//    if ($response->successful()) {
//        $data = $response->json();
//
//        // Access the country information
//        $countryName = $data['geoplugin_countryCode'];
//
//        return $countryName;
//    } else {
//        // Handle the case where the request fails
//        return "Unable to retrieve country information";
//    }
    // return  $messageService->email('giorgi.devadze@asyasoftware.ge',$text);
});

Route::get('/', function () {
    if (Auth::check()){
        return redirect()->to('dashboard');
    }
    return view('auth.login');
})->name('index');

Route::get('/test_img', function (){
    $records = \App\Models\Movement::whereRaw('DATEDIFF(end_date, start_date) > 1')
        ->whereMonth('start_date', 1)
//        ->whereMonth('end_date', 1)
        ->get();
//    return $records;
    foreach ($records as  $record){
        \App\Models\Movement::create([
            'user_id' => $record->user_id,
            'working_schedule_id' => $record->working_schedule_id,
            'dynamic_working_schedule_id' => $record->dynamic_working_schedule_id,
            'card_number' => $record->card_number,
            'start_date' => $record->end_date,
        ]);
        $record->update(['end_date' => null]);
    }
    return  $records;
//    $userCompanies = \App\Models\UserCompany::all()->unique('user_id');
////    return $userCompanies;
//    foreach ($userCompanies as $userCompany){
//        UserVacationQuantity::updateOrCreate([
//            'user_id' => $userCompany->user_id,
//            'year' => 2025,
//        ],[
//            'quantity' => 24,
//            'current_quantity' => 0
//        ]);
//    }
////    return view('pages.canvas');
});

Route::get('/export', function (){

     return Excel::download(new \App\Exports\DynamicWorkingScheduleExport(), 'vacation-' . date('d.m.Y') . '.xlsx');

//    $monthDays = cal_days_in_month(CAL_GREGORIAN, 8, 2023);
//    $users = User::where('company_id',session()->get('company_id'))->with('movements')->with('working_schedule')->get()
//        ?->map?->getWorkedHoursByDay('2023', '08');
//    $company = Company::findOrFail(session()->get('company_id'));
//    $date = Carbon::today()->format('d.m.Y');
//    return view('exports.report', [
//        'users' => $users,
//        'company' => $company,
//        'date' => $date,
//        'month_days' => $monthDays,
//    ]);
//
    return Excel::download(new \App\Exports\TabelExport(), 'tabel-' . date('d.m.Y') . '.xlsx');
});

Route::get('locale/{locale}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
})->name('locale');

Route::get('/phpinfo', function (){
// Example usage
    $startTime = '2024-02-06 15:00:00';
    $endTime = '2024-02-06 23:00:00';

    $nightHours = calculateNightHours($startTime, $endTime);
    echo "Night hours: $nightHours";
//    phpinfo();
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('set_company', function () {
        $users = User::whereNotNull('working_schedule_id')->get();
        foreach ($users as $user){
            \App\Models\UserCompany::create([
                'user_id' => $user->id,
                'company_id' => $user->company_id,
                'position_id' => $user->position_id,
                'working_schedule_id' => $user->working_schedule_id
            ]);
        }
    })->name('set.company');
    Route::get('/choose_company',function (){
        if (Session::has('company_id')){
            return redirect()->to('dashboard');
        }
        $companies = Company::all();

        return view('pages.choose_company',compact('companies'));
    });
    Route::middleware(['auth'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        Route::group(['prefix' => 'dynamic_working_schedule', 'as' => 'dynamic.working.schedule.'], function () {
            Route::get('/', [DynamicWorkingScheduleController::class, 'index'])->name('index');
            Route::post('/ajax', [DynamicWorkingScheduleController::class, 'ajax'])->name('ajax');
            Route::post('/update', [DynamicWorkingScheduleController::class, 'update'])->name('update');
            Route::post('/working_schedule_time_list_render',[DynamicWorkingScheduleController::class,'workingScheduleTimeListRender'])->name('time.list.render');
            Route::post('/working_schedule_set_time_users',[DynamicWorkingScheduleController::class,'workingScheduleSetTimeUsers'])->name('set.time.users');
        });

        Route::group(['prefix' => 'dynamic_working_schedule_time', 'as' => 'dynamic.working.schedule.time.'], function () {
            Route::get('/', [DynamicWorkingScheduleTimeController::class, 'index'])->name('index');
            Route::post('/ajax', [DynamicWorkingScheduleTimeController::class, 'dynamicWorkingScheduleTimeAjax'])->name('ajax');
            Route::get('/create',[DynamicWorkingScheduleTimeController::class,'create'])->name('create');
            Route::post('/store',[DynamicWorkingScheduleTimeController::class,'store'])->name('store');
            Route::get('/{id}/edit',[DynamicWorkingScheduleTimeController::class,'edit'])->name('edit');
            Route::post('/{id}/update',[DynamicWorkingScheduleTimeController::class,'update'])->name('update');
        });

        Route::group(['prefix' => 'holidays', 'as' => 'holidays.'], function () {
            Route::get('/', [HolidayController::class, 'index'])->name('index');
            Route::post('/ajax', [HolidayController::class, 'ajax'])->name('ajax');
            Route::post('/store', [HolidayController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'messages', 'as' => 'messages.'], function () {
            Route::get('/', [MessageController::class, 'index'])->name('index');
            Route::post('/send', [MessageController::class, 'sendMessage'])->name('send');
            Route::post('/store', [HolidayController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'settings','as' => 'settings.'], function (){
            Route::group(['prefix' => 'departments','as' => 'departments.'], function (){
                Route::get('/',[DepartmentController::class,'index'])->name('index');
                Route::post('/create',[DepartmentController::class,'create'])->name('create');
                Route::post('/edit',[DepartmentController::class,'edit'])->name('edit');
                Route::post('/store',[DepartmentController::class,'store'])->name('store');
                Route::post('/update/{id}',[DepartmentController::class,'update'])->name('update');
                Route::post('/ajax',[DepartmentController::class,'ajax'])->name('ajax');
            });

            Route::group(['prefix' => 'positions','as' => 'positions.'], function (){
                Route::get('/',[PositionController::class,'index'])->name('index');
                Route::post('/create',[PositionController::class,'create'])->name('create');
                Route::post('/store',[PositionController::class,'store'])->name('store');
                Route::post('/ajax',[PositionController::class,'ajax'])->name('ajax');
                Route::post('/edit',[PositionController::class,'edit'])->name('edit');
                Route::post('/update/{id}',[PositionController::class,'update'])->name('update');
                Route::post('/delete_position',[PositionController::class,'deletePosition'])->name('delete.position');
            });

            Route::group(['prefix' => 'readers', 'as' => 'readers.'], function (){
                Route::get('/import_data',[ReaderController::class,'importData'])->name('import.data');
            });

            Route::group(['prefix' => 'general','as' => 'general.'], function (){
                Route::get('/',[GeneralSettingController::class,'index'])->name('index');
                Route::post('/update',[GeneralSettingController::class,'update'])->name('update');
            });
        });

        Route::group(['prefix' => 'reports','as' => 'reports.'], function (){
            Route::group(['prefix' => 'movements','as' => 'movements.'], function (){
                Route::get('/',[ReportController::class,'movements'])->name('index');
                Route::post('/ajax',[ReportController::class,'movementsAjax'])->name('ajax');
                Route::get('/create',[ReportController::class,'movementCreate'])->name('create');
                Route::post('/store',[ReportController::class,'movementStore'])->name('store');
                Route::get('/edit/{id}',[ReportController::class,'movementEdit'])->name('edit');
                Route::post('/edit_render',[ReportController::class,'movementEditRender'])->name('edit.render');
                Route::get('/export_excel/{start_date}/{end_date}',[ReportController::class,'movementsExportExcel'])->name('export.excel');
                Route::post('/import_movements_excel',[ReportController::class,'movementsImportExcel'])->name('import.movements.excel');
                Route::post('/update/{id}',[ReportController::class,'movementUpdate'])->name('update');
            });

            Route::group(['prefix' => 'rs','as' => 'rs.'], function (){
                Route::get('/',[ReportController::class,'rs'])->name('index');
                Route::post('/ajax',[ReportController::class,'rsAjax'])->name('ajax');
            });

            Route::group(['prefix' => 'hr_table','as' => 'hr_table.'], function (){
                Route::get('/{type}',[ReportController::class,'hrTable'])->name('index');
                Route::post('/ajax',[ReportController::class,'hrTableAjax'])->name('ajax');
                Route::get('/export_excel/{id}/{selectedDate}/{type}',[ReportController::class,'exportHrTable'])->name('export.excel');
            });

            Route::group(['prefix' => 'confirmation_movements','as' => 'confirmation_movements.'], function (){
                Route::get('/',[ReportController::class,'confirmationMovement'])->name('index');
                Route::post('/ajax',[ReportController::class,'confirmationMovementsAjax'])->name('ajax');
                Route::post('/render',[ReportController::class,'confirmationMovementsRender'])->name('render');
                Route::post('/update_data',[ReportController::class,'confirmationMovementUpdateData'])->name('update.data');
                Route::get('/export_excel/{id}/{selectedDate}/{type}',[ReportController::class,'exportHrTable'])->name('export.excel');
            });

            Route::group(['prefix' => 'worked_hours','as' => 'worked.hours.'], function (){
                Route::get('/{type}',[ReportController::class,'workedHours'])->name('index');
                Route::post('/ajax',[ReportController::class,'workedHoursAjax'])->name('ajax');
                Route::get('/export_excel/{id}/{selectedDate}/{type}',[ReportController::class,'exportWorkedHoursTable'])->name('export.excel');
            });

            Route::group(['prefix' => 'dynamic_shift','as' => 'dynamic.shift.'], function (){
                Route::get('/',[ReportController::class,'dynamicShift'])->name('index');
                Route::post('/ajax',[ReportController::class,'dynamicShiftAjax'])->name('ajax');
                Route::get('/export_excel/{id}/{selectedDate}',[ReportController::class,'exportDynamicShift'])->name('export.excel');
            });
        });


        Route::group(['prefix' => 'languages', 'as' => 'languages.'], function () {
            Route::get('/', [LanguageController::class, 'index'])->name('index');
            Route::get('/{code}/show', [LanguageController::class, 'show'])->name('show');
            Route::get('/json_lang_import', [LanguageController::class, 'jsonLangImport'])->name('json.lang.import');
            Route::post('/show/ajax', [LanguageController::class, 'languageJsonAjax'])->name('show.ajax');
            Route::post('/create_language_json', [LanguageController::class, 'createLanguageJson'])->name('create.language.json');
            Route::post('/edit_language_json', [LanguageController::class, 'editLanguageJson'])->name('edit.language.json');
            Route::post('/store_language_json/{id}', [LanguageController::class, 'storeLanguageJson'])->name('store.language.json');
            Route::post('/update_language_json/{id}', [LanguageController::class, 'updateLanguageJson'])->name('update.language.json');
            Route::post('/delete_language_json', [LanguageController::class, 'deleteLanguageJson'])->name('delete.language.json');
        });

        Route::get('change_password',[ProfileController::class,'changePassword'])->name('change.password');
        Route::post('update_password',[ProfileController::class,'updatePassword'])->name('update.password');

        Route::group(['prefix' => 'user','as' => 'user.'], function (){
            Route::get('/',[StaffController::class,'userMovementAction'])->name('movement.action');
        });

        Route::post('staff_info', [StaffController::class, 'renderStaffInfo'])->name('staff_info.info');

        Route::get('/testsssssssssss', function () {
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, 01, 2023);
            $movements = \App\Models\Movement::all()->unique('user_id');
            return view('pages.attendance', compact('daysInMonth', 'movements'));
        });

        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::post('/{id}/update', [UserController::class, 'update'])->name('update');
            Route::get('/{id}/show', [UserController::class, 'show']);
            Route::get('/create', [UserController::class, 'create'])->name('create');
            Route::post('/create_render', [UserController::class, 'createRender'])->name('create.render');
            Route::post('/store', [UserController::class, 'store'])->name('store');
            Route::post('/users_ajax', [UserController::class, 'getUsersForAjax'])->name('ajax');
            Route::post('/user_files_ajax/{id}', [UserController::class, 'getUserFilesForAjax'])->name('files.ajax');
            Route::post('/user_vacations_ajax/{id}', [UserController::class, 'getUserVacationForAjax'])->name('vacations.ajax');
            Route::post('/user_vacation_quantities_ajax/{id}', [UserController::class, 'getUserVacationQuantitiesForAjax'])->name('vacation.quantities.ajax');
            Route::post('/change_vacation_days_status', [UserController::class, 'changeVacationDaysStatus'])->name('change.vacation.days.status');
            Route::post('/change_vacation_days', [UserController::class, 'changeVacationDays'])->name('change.vacation.days');
            Route::post('/delete_user', [UserController::class, 'deleteUser']);
            Route::post('/upload_files/{id}', [UserController::class, 'uploadFiles'])->name('upload.files');
            Route::post('/save_vacation_days/{id}', [UserController::class, 'saveVacationDays'])->name('save.vacation.days');
            Route::get('/download_file/{id}', [UserController::class, 'downloadFile'])->name('download.file');
            Route::post('/edit_user_company', [UserController::class, 'editUserCompany'])->name('edit.user.company');
            Route::post('/update_user_company/{id}', [UserController::class, 'updateUserCompany'])->name('update.user.company');
            Route::post('/user_card_register_render', [UserController::class, 'userCardRegisterRender'])->name('card.register.render');
            Route::post('/user_card_register/{id}', [UserController::class, 'userCardRegister'])->name('card.register');


            Route::post('/reset_password',[UserController::class,'resetPassword'])->name('reset.password');
            Route::post('/account_disable',[UserController::class,'accountDisable'])->name('account.disable');

            Route::get('/delays',[UserController::class,'delays'])->name('delays');
            Route::post('/delays_ajax',[UserController::class,'delaysAjax'])->name('delays.ajax');

            Route::get('/subordinates',[UserController::class,'subordinates'])->name('subordinates');
            Route::post('/subordinates_ajax',[UserController::class,'subordinatesAjax'])->name('subordinates.ajax');

            Route::get('/movements_pdf/{id}',[StaffController::class,'getMovementsPdf'])->name('movements.pdf');

            Route::get('/impersonate/{id}', function ($id) {
                $user = User::findOrFail($id);
                Auth::user()->impersonate($user);
                return redirect(url('/dashboard'));
            });
            Route::get('/impersonate_leave', function () {
                Auth::user()->leaveImpersonation();
                return redirect(url('/dashboard'));
            });
        });

        Route::group(['prefix' => 'working_schedule', 'as' => 'working.schedule.'], function () {
            Route::get('/', [WorkingScheduleController::class, 'index'])->name('index');
            Route::get('/working_schedule_ajax', [WorkingScheduleController::class, 'workingScheduleAjax'])->name('ajax');
            Route::get('/create', [WorkingScheduleController::class, 'create'])->name('create');
            Route::post('/store', [WorkingScheduleController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [WorkingScheduleController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [WorkingScheduleController::class, 'update'])->name('update');
        });

        Route::group(['prefix' => 'vacations','as' => 'vacations.'], function (){
            Route::get('/',[VacationController::class,'index'])->name('index');
            Route::post('/ajax', [VacationController::class, 'getHonorableReasonsAjax'])->name('ajax');
            Route::post('/confirm', [VacationController::class, 'confirmVacation'])->name('confirm');
            Route::post('/reject', [VacationController::class, 'rejectVacation'])->name('reject');
            Route::get('/pdf/{id}', [VacationController::class, 'pdf'])->name('pdf');
        });

        Route::group(['prefix' => 'user','as' => 'user.'], function (){

            Route::get('/working_schedule',[UserWorkingScheduleController::class,'index'])->name('working.schedule');

            Route::group(['prefix' => 'movements','as' => 'movements.'], function (){
                Route::get('/',[UserMovementController::class,'index'])->name('index');
                Route::post('/movements_ajax',[UserMovementController::class,'getMovementsAjax'])->name('ajax');
                Route::post('/save_delay_reason/{id}',[UserMovementController::class,'saveDelayReason'])->name('save.delay.reason');
            });

            Route::group(['prefix' => 'vacations','as' => 'vacations.'], function (){
                Route::get('/',[UserVacationController::class,'index'])->name('index');
                Route::post('/ajax', [UserVacationController::class, 'getHonorableReasonsAjax'])->name('ajax');
                Route::post('/create', [UserVacationController::class, 'createRender'])->name('create');
                Route::post('/store', [UserVacationController::class, 'store'])->name('store');
            });
        });

        Route::group(['prefix' => 'roles'], function () {
            Route::get('/', [RoleController::class, 'index']);
            Route::get('/create', [RoleController::class, 'create']);
            Route::post('/store', [RoleController::class, 'store']);
            Route::get('/{id}/edit', [RoleController::class, 'edit']);
            Route::patch('/{id}/update', [RoleController::class, 'update']);
            Route::post('/delete_role', [RoleController::class, 'deleteRole']);
        });
    });
});

