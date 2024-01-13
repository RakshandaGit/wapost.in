<?php

namespace App\Jobs;

use DB;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use App\Models\EmailTemplates;
use App\Mail\PlanExpireTodayEmail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PlanExpireTodayJob
{
    use Dispatchable;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Log::debug("run check:planexpiretoday => Job file => PlanExpireTodayJob => handle datetime: ".date('d-m-Y H:s:i'));

        $today_date = date('Y-m-d');

        $userIds = Subscription::whereDate('current_period_ends_at', '=', $today_date)
        ->groupBy('user_id')
        ->pluck('user_id')
        ->toArray();  
        
        $users = User::whereIn('id', $userIds)->where('status', 1)->get();
        
        if (!empty($users)) {
            foreach ($users as $key => $user) {
                $data = [
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name ?? '',
                    'mobile' => $user->mobile,
                    'email' => $user->email,
                ];

                $email_info = EmailTemplates::where('slug', 'plan_expire_today')->first();
                $data['content'] = $email_info['content'];
                $data['subject'] = $email_info['subject'];

                $email = new PlanExpireTodayEmail($data);
                Mail::to($user->email)->send($email);
            }
        }

    }
}
