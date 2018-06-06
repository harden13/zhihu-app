<?php

namespace App\Notifications;

use App\Channels\SendCloudChannel;
use App\Mailer\UserMailer;
use Auth;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Naux\Mail\SendCloudTemplate;
use Mail;

class NewUserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', SendCloudChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//                    ->line('The introduction to the notification.')
//                    ->action('Notification Action', 'https://laravel.com')
//                    ->line('Thank you for using our application!');
//    }

    /**
     * @return array
     */
    public function toDatabase()
    {
        return [
            'name' => Auth::guard('api')->user()->name,
        ];
    }

    public function toSendcloud($notifiable)
    {
        (new UserMailer())->followNotifyEmail($notifiable->email);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
