<?php

namespace App\Mail;

use App\Helpers\Helper;
use App\Models\EmailTemplates;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUsMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $customer_name;

    /**
     * render sms with tag
     *
     * @param $msg
     * @param $data
     *
     * @return string|string[]
     */
    public function renderTemplate($msg, $data)
    {
        preg_match_all('~{(.*?)}~s', $msg, $datas);

        foreach ($datas[1] as $value) {
            if (array_key_exists($value, $data)) {
                $msg = preg_replace("/\b$value\b/u", $data[$value], $msg);
            } else {
                $msg = str_ireplace($value, '', $msg);
            }
        }

        return str_ireplace(["{", "}"], '', $msg);
    }

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->customer_name     = $data['name'];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $template = EmailTemplates::where('slug', 'contact_us')->first();

        $subject = $this->renderTemplate($template->subject, [
                'app_name' => config('app.name'),
        ]);
        $content = $this->renderTemplate($template->content, [
                'customer_name'     => $this->customer_name,
        ]);

        return $this->from('no-reply@wapost.net', Helper::app_config('notification_from_name'))
                ->subject($subject)
                ->markdown('emails.user_contact_us', [
                        'content' => $content,
                ]);
    }
}
