<?php

namespace App\Console;

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
        Commands\CookingPointCron::class,
        Commands\GmailCredentials::class,
        Commands\EventLoader::class,
        Commands\LegacyBookingLoader::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('cookingpoint:cron')->dailyAt('04:00');

        $schedule->call(function () {
            // Fill-in Payment method paella
            $a = new PaymentMethod('PAELLA');
            if ($a->query()) { $a->exec(); }
        })->dailyAt('06:00');       

        $schedule->call(function () {
            // Fill-in Payment method paella
            $a = new PaymentMethod('TAPAS');
            if ($a->query()) { $a->exec(); }
        })->dailyAt('13:00'); 
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
