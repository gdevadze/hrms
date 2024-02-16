<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale'))
        {
            App::setlocale(Session::get('locale'));
        }
        // else if (in_array($userLangs, $availableLangs))
        // {
        //     App::setLocale($userLangs);
        //     Session::put('locale', $userLangs);
        // }
        else {
            App::setLocale('ka');
            Session::put('locale', 'ka');
        }
        return $next($request);
    }
}
