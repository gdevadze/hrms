<?php

namespace App\Http\Controllers\Api;

use App\Enums\VacationType;
use App\Http\Controllers\Controller;
use App\Models\Movement;
use App\Models\User;
use App\Models\Vacation;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $todayMovement = Movement::where('user_id',$request->user()->id)->whereDate('start_date',Carbon::today())->latest()->first();
        
        $userTotalVacation = apiUser()->user_vacation_quantities()->sum('quantity');
        $usedUserVacations = apiUser()->user_vacation_quantities()->sum('current_quantity');
        $vacationDays = $userTotalVacation - $usedUserVacations;



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

        return jsonResponse(['today_movement' => $todayMovement,'vacation_used_days' => $usedUserVacations,'total_vacation_days' => $userTotalVacation,'vacation_days' => $vacationDays,'birthdays' => $birthdays,'white_list' => $ipCollection]);
    }

    public function userMovementAction(): JsonResponse
    {
        $movement = Movement::where('user_id',currentUser()->id)->whereDate('start_date', Carbon::today())->first();
        if (isset($movement)){
            $movement->update(['end_date' => Carbon::now()]);
        }else{
            Movement::create([
                'user_id' => currentUser()->id,
                'card_number' => currentUser()->card_number,
                'start_date' => Carbon::now()
            ]);
        }
        return jsonResponse(['status' => 1]);
    }
}
