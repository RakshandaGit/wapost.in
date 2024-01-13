<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PlanExpire5Day extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:expirefiveday';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dispatch(new \App\Jobs\PlanExpire5DayJob());
    }
}
