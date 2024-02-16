<?php


namespace App\Providers;

use App\Models\Card;
use App\Models\Company;
use App\Models\CompanyMail;
use App\Models\Domain;
use App\Models\GeneralSetting;
use App\Models\Language;
use App\Models\License;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        View::composer(
            'profile', 'App\Http\View\Composers\ProfileComposer'
        );

        View::composer(['layouts.app','auth.login'], function ($view) {
            $languages = Language::all();
            $view
                ->with('languages', $languages)
            ;
        });
        // Using Closure based composers...
        View::composer('dashboard', function ($view) {
            $usersCount = User::all()->count();
            $view
                ->with('usersCount', $usersCount)
            ;
        });
    }
}
