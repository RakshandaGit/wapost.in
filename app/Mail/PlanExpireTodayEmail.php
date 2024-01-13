<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Library\Tool;

class PlanExpireTodayEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $content = Tool::renderTemplate($this->data['content'], [
            'customer_name' => $this->data['first_name'].' ' .$this->data['last_name'],
        ]);

        return $this->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'))
        ->subject(ucfirst($this->data['first_name'].' '. $this->data['last_name'].', '. $this->data['subject']))
        ->markdown('emails.subscription.plan_expire_today', ['content' => $content]);
    }
}
