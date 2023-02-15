<?php

use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkingScheduleController;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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

Route::get('/testunia', function (){
    $siteSettings = \App\Models\GeneralSetting::all()->keyBy('key');
    return $siteSettings['site_title']->value;
});

Route::get('/', function () {
    if (Auth::check()){
        return redirect()->to('dashboard');
    }
    return view('auth.login');
});

Route::get('/lasuridze', function (){
    $users = User::all(['name','card_number']);
    return jsonResponse($users,200,['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'],JSON_UNESCAPED_UNICODE);
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('set_company/{company_id}', function ($companyId) {
        Session::put('company_id', $companyId);
        return redirect()->to('dashboard');
    })->name('set.company');
    Route::get('/choose_company',function (){
        if (Session::has('company_id')){
            return redirect()->to('dashboard');
        }
        $companies = Company::all();
        return view('pages.choose_company',compact('companies'));
    });
    Route::middleware(['auth','company'])->group(function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

        Route::group(['prefix' => 'holidays', 'as' => 'holidays.'], function () {
            Route::get('/', [HolidayController::class, 'index'])->name('index');
            Route::post('/ajax', [HolidayController::class, 'ajax'])->name('ajax');
            Route::post('/store', [HolidayController::class, 'store'])->name('store');
        });

        Route::group(['prefix' => 'languages', 'as' => 'languages.'], function () {
            Route::get('/', [LanguageController::class, 'index'])->name('index');
            Route::get('/{code}/show', [LanguageController::class, 'show'])->name('show');
            Route::post('/update_json', [LanguageController::class, 'saveLanguageJson'])->name('update.json');
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
            Route::post('/update', [UserController::class, 'update'])->name('update');
            Route::get('/{id}/show', [UserController::class, 'show']);
            Route::get('/create', [UserController::class, 'create']);
            Route::post('/store', [UserController::class, 'store']);
            Route::get('/users_ajax', [UserController::class, 'getUsersForAjax'])->name('ajax');
            Route::post('/delete_user', [UserController::class, 'deleteUser']);
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

