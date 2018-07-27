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

        $schedule->command('cookingpoint:cron')->dailyAt('13:00');

        $schedule->call(function () {
            // Fill-in Payment method paella
            $a = new Commands\PaymentMethod('PAELLA');
            if ($a->query()) { $a->exec(); }
        })->dailyAt('15:00');       

        $schedule->call(function () {
            // Fill-in Payment method paella
            $a = new Commands\PaymentMethod('TAPAS');
            if ($a->query()) { $a->exec(); }
        })->dailyAt('22:00'); 
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
    }
}
