<?php

namespace App\Providers;

use App\Events\GameIsOver;
use App\Events\Game\GameSlotUpdated;
use App\Listeners\CalculateElo;
use App\Listeners\UpdateGameElo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //require_once "app/helpers.php";
            Event::listen(
                GameIsOver::class,
                CalculateElo::class,
                GameSlotUpdated::class,
                UpdateGameElo::class
            );
    }
}
