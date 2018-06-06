<?php
/**
 * Created by PhpStorm.
 * User: young
 * Date: 2018/6/6
 * Time: 上午10:10
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;

class SendCloudChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSendcloud($notifiable);
    }
}