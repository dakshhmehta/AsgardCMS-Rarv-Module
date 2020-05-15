<?php

namespace Modules\Rarv\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\Rarv\Channels\SMSChannel;
use Modules\Rarv\Channels\SMSMessage;
use Modules\Rarv\Contracts\SMSable;

class SendSMS extends Notification
{
    private $message;

    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        //
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SMSChannel::class];
    }

    public function toSMS($notifiable)
    {
        $mobile = env('MOBILE_NO');

        if($notifiable instanceof SMSable){
            $mobile = $notifiable->getMobileNo();
        }

        $message = new SMSMessage($mobile, $this->message, $notifiable);
        return $message;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
