<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
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
        $schedule->call(function () {
            DB::select(
                'call proc1'
            );
        })->daily();
        $schedule->call(function () {
            $login = DB::table('login');
            DB::select('call status');
        })->monthly();
        $schedule->call(function () {
            $logins = DB::table('Logins')->all();
            foreach ($logins as $login){
                $login->day = 0;
                $login->night = 0;
                $login->save();
            }
        })->monthly();
        $schedule->call(function () {
            $logins = DB::table('failAuth')->all();
            foreach ($logins as $login){
                $login->fails = 0;
                $login->save();
            }
        })->daily();

        $schedule->call(function (){
            $user = User::all()
                ->find(Auth::user());
            if ($user->isBlock == 1){
                auth()->logout();
                $user->isAuth=0;
                $user->save();
            }
        })->hourly();

        $schedule->call(function () {
            $users = User::all();
            foreach ($users as $user){
                if ($user->isBlock == 1){
                    $user->isBlock = 0;
                    $user->save();
                }
            }
        })->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');
    }
}
