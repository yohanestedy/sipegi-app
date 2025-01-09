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
        // $schedule->command('inspire')->hourly();

        // PINDAHKAN BALITA LULUS
        // $schedule->call(function () {
        //     app()->call('App\Http\Controllers\BalitaController@pindahkanBalitaLulus');
        // })->everyMinute();

        // Menjalankan pindahkanBalitaLulus setiap hari pukul 00:00 tengah malam
        $schedule->call(function () {
            app()->call('App\Http\Controllers\BalitaController@pindahkanBalitaLulus');
        })->dailyAt('00:00');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
