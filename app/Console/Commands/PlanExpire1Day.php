<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class PlanExpire1Day extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:expireoneday';

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
        dispatch(new \App\Jobs\PlanExpire1DayJob());
    }
}
