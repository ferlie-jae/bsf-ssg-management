<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Election;
use Carbon\Carbon;

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
        /* $schedule->command('config:cache')
                 ->everyMinute(); */
        $schedule->call(function(){
            $now = Carbon::now();
            $activeElections = Election::get();
            if($activeElections->count() > 0){
                foreach($activeElections as $activeElection){
                    // $election = Election::find($activeElection->id);
                    if($activeElection->start_date->gt($now)){
                        Election::find($activeElection->id)->update(['status' => 'incoming']);
                    }
                    elseif($activeElection->start_date->lt($now) && $activeElection->end_date->gt($now)){
                        Election::find($activeElection->id)->update(['status' => 'ongoing']);
                    }
                    elseif($activeElection->end_date->lt($now)){
                        Election::find($activeElection->id)->update(['status' => 'ended']);
                    }
                }
            }
        })->everyMinute();
        /* $schedule->call(function(){
            echo "sample";
        })->everyMinute()
        ->runInBackground(); */
        
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
