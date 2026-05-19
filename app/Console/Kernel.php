<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Schedule the publish scheduled posts command to run every minute
        $schedule->call(function () {
            \Illuminate\Support\Facades\Artisan::call('app:publish-scheduled-posts');
        })->everyMinute();
    }
}
