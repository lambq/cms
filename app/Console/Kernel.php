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
    protected $filePath = 'schedule.txt';
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $menu = getMenu();
        $path = base_path();
        $path = 'php '.$path.'/artisan ';
        foreach ($menu as $v)
        {
            $schedule->exec($path.'page-cache:clear '.$v->name)->everyThirtyMinutes()->withoutOverlapping(10)->sendOutputTo($this->filePath);
        }
        $schedule->exec($path.'page-cache:clear pc__index__pc')->everyThirtyMinutes()->withoutOverlapping(10)->sendOutputTo($this->filePath);
        $schedule->exec($path.'page-cache:clear top')->everyThirtyMinutes()->withoutOverlapping(10)->sendOutputTo($this->filePath);
        $schedule->exec($path.'page-cache:clear update')->everyThirtyMinutes()->withoutOverlapping(10)->sendOutputTo($this->filePath);
        $schedule->exec($path.'dig:model all')->dailyAt('08:00')->withoutOverlapping(10)->sendOutputTo($this->filePath);
        $schedule->exec($path.'dig:sitetxt')->everyFiveMinutes()->withoutOverlapping(10)->sendOutputTo($this->filePath);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
