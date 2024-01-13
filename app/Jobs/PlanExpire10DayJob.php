<?php

namespace App\Jobs;

use DB;
use Mail;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use App\Models\EmailTemplates;
use App\Mail\PlanExpire10DayMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PlanExpire10DayJob
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
        // Log::debug("run plan:expiretenday => Job file => PlanExpire10DayJob => handle datetime: ".date('d-m-Y H:s:i'));

        $ten_day_before = Carbon::now()->addDay(10);

        $userIds = Subscription::whereDate('current_period_ends_at', '=', $ten_day_before)
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

                $email_info = EmailTemplates::where('slug', 'plan_expire_10_day')->first();
                $data['content'] = $email_info['content'];
                $data['subject'] = $email_info['subject'];

                $email = new PlanExpire10DayMail($data);
                Mail::to($user->email)->send($email);
            }
        }

    }
}
