<?php

namespace App\Providers;

use App\Services\Contracts\WorkSchedulingServiceContract;
use App\Services\WorkSchedulingService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
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
        $this->app->bind(WorkSchedulingServiceContract::class, WorkSchedulingService::class);
    }
}
