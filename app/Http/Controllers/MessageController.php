<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MessageService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $users = User::whereHas('user_companies', function ($q){
            return $q->whereDate('contract_end_date','>=',Carbon::today())->orWhereNull('contract_end_date')->where('working_schedule_id',2);
        })->get();
        return view('pages.messages.index',compact('users'));
    }

    public function sendMessage(Request $request,MessageService $messageService): RedirectResponse
    {
        if(!$request->user_ids){
            return redirect()->back()->with('error','შეცდომა, გთხოვთ აირჩიეთ თანამშრომლები!');
        }
        $users = User::whereIn('id',$request->user_ids)->get();
        foreach ($users as $user){
            $messageService->sms($user->tel,$request->message_text);
        }

        return redirect()->back()->with('success','შეტყობინება წარმატებით გაიგზავნა!');
    }
}
