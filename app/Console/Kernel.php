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
        if(env('PACKAGE','A1') != 'A1') {
            $schedule->command('attendance-close:cron')
            ->dailyAt('23:30')
            ->runInBackground();

            $schedule->command('prepare-attendance:cron')
                ->everyMinute()
                ->runInBackground();
        }
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
