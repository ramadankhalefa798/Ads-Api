<?php

namespace App\Console;

use App\Console\Commands\UsersMailing;
use App\Jobs\SendMails;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UsersMailing::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        # Get users who have ads tomorrow , and dispatch jobs 
        $schedule->command('users:mailing')->dailyAt('19:30');

        # Run queue to work on created jobs
        $schedule->command('queue:work')->dailyAt('20:00');
        $schedule->command('queue:restart')->dailyAt('20:30');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
