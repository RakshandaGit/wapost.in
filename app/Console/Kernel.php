<?php

namespace App\Console;

use App\Console\Commands\CheckKeywords;
use App\Console\Commands\CheckPhoneNumbers;
use App\Console\Commands\CheckSenderID;
use App\Console\Commands\CheckSessionWhatSender;
use App\Console\Commands\CheckSubscription;
use App\Console\Commands\CheckUserPreferences;
use App\Console\Commands\ClearCampaign;
use App\Console\Commands\RunCampaign;
use App\Console\Commands\UpdateDemo;
use App\Console\Commands\UpdateImartGroupDLR;
use App\Console\Commands\VisionUpInboundMessage;
use App\Console\Commands\WhatsenderInbound;
use App\Console\Commands\PlanExpireToday;
use App\Console\Commands\PlanExpire1Day;
use App\Console\Commands\PlanExpire5Day;
use App\Console\Commands\PlanExpire10Day;
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
            CheckSubscription::class,
            CheckKeywords::class,
            CheckPhoneNumbers::class,
            CheckSenderID::class,
            CheckUserPreferences::class,
            RunCampaign::class,
            UpdateDemo::class,
            WhatsenderInbound::class,
            VisionUpInboundMessage::class,
            UpdateImartGroupDLR::class,
            CheckSessionWhatSender::class,
            ClearCampaign::class,
            PlanExpireToday::class,
            PlanExpire1Day::class,
            PlanExpire5Day::class,
            PlanExpire10Day::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  Schedule  $schedule
     *
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        $schedule->command('queue:work --once --tries=1')->everyMinute();
        $schedule->command('campaign:run')->everyMinute();
        $schedule->command('subscription:check')->hourly();
        $schedule->command('imartgroup:dlr')->everyThirtyMinutes();
        $schedule->command('keywords:check')->daily();
        $schedule->command('numbers:check')->daily();
        $schedule->command('senderid:check')->daily();
        $schedule->command('user:preferences')->daily();
        $schedule->command('plan:expiretoday')->dailyAt('00.00');
        $schedule->command('plan:expireoneday')->dailyAt('00.00');
        $schedule->command('plan:expirefiveday')->dailyAt('00.00');
        $schedule->command('plan:expiretenday')->dailyAt('00.00');

        // $schedule->command('visionup:inbound')->hourly();
        // $schedule->command('session:whatsender')->everyFiveMinutes();
        $schedule->command('whatsender:inbound')->everyTwoMinutes();

        if (config('app.stage') == 'demo') {
            $schedule->command('demo:update')->daily();
        }
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
