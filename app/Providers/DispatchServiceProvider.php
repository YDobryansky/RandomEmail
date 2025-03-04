<?php
/**
 * Create: Volodymyr
 */

namespace App\Providers;

use App\Console\Commands\SendDispatchCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class DispatchServiceProvider extends ServiceProvider
{

    public function boot()
    {

        if ($this->app->runningInConsole()) {

            $this->commands([
                SendDispatchCommand::class,
            ]);

            $this->app->booted(function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command('app:send-dispatch')->everyMinute();
            });
        }

    }

}
