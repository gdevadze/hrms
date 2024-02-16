<?php

namespace App\Http\Controllers;

use App\Enums\VacationType;
use App\Models\Holiday;
use App\Models\Vacation;
use App\Models\Movement;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $holidays = Holiday::count();
        Carbon::setLocale(currentLocale());
        $currentDayName = Carbon::today()->translatedFormat('l');
        $todayMovement = Movement::where('user_id',currentUser()->id)->whereDate('start_date',Carbon::today())->latest()->first();

        $todayMovements = Movement::whereDate('start_date',Carbon::today())->get()->sortBy(function ($q){
            return $q->user->company_id;
        });

        $userVacation = currentUser()->user_vacation_quantities()->sum('quantity');
        $usedUserVacations = currentUser()->user_vacation_quantities()->sum('current_quantity');

        $today = Carbon::today();
        $tomorrow = Carbon::tomorrow();

        $birthdays = User::whereMonth('birthdate', '=', $today->month)
            ->whereDay('birthdate', '=', $today->day)
            ->orWhere(function ($query) use ($tomorrow) {
                $query->whereMonth('birthdate', '=', $tomorrow->month)
                    ->whereDay('birthdate', '=', $tomorrow->day);
            })
            ->orderBy('birthdate')
            ->get(['name_ka','surname_ka','birthdate']);

        $whitelist = file_get_contents(public_path('whitelist.json'));
        $jsonArr = json_decode($whitelist, true);
        $ipCollection = collect($jsonArr)->pluck('ip')->toArray();
        return view('dashboard',compact('users','holidays','currentDayName','todayMovement','userVacation','usedUserVacations','todayMovements','birthdays','ipCollection'));
    }
}
