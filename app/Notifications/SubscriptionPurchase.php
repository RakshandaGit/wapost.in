<?php

namespace App\Notifications;

use App\Helpers\Helper;
use App\Library\Tool;
use App\Models\EmailTemplates;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionPurchase extends Notification
{

    use Queueable;

    protected string $invoice_url;
    protected string $first_name;
    protected string $last_name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($invoice_url, $first_name, $last_name)
    {
        $this->invoice_url = $invoice_url;
        $this->first_name = $first_name;
        $this->last_name = $last_name ?? '';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     *
     * @return MailMessage
     */
    public function toMail($notifiable)
    {

        $template = EmailTemplates::where('slug', 'subscription_notification')->first();

        $subject = Tool::renderTemplate($template->subject, [
                'app_name' => config('app.name'),
        ]);

        $content = Tool::renderTemplate($template->content, [
                'app_name'    => config('app.name'),
                'invoice_url' => "<a href='$this->invoice_url' target='_blank'>".__('locale.labels.invoice')."</a>",
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
        ]);

        return (new MailMessage)
                ->from(Helper::app_config('notification_email'), Helper::app_config('notification_from_name'))
                ->subject($subject)
                ->markdown('emails.subscription.purchase', ['content' => $content, 'url' => $this->invoice_url]);
    }
}
