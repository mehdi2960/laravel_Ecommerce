<?php

namespace App\Channels;

use Ghasedak\GhasedakApi;
use Illuminate\Notification\Notification;


class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $receptor = $notifiable->cellphone;
        $type = 1;
        $template = "Products";
        $param1 = $notification->code;
        $api = new GhasedakApi(env('GHASEDAK_API_KEY'));
        $api->Verify($receptor, $type, $template, $param1);
    }
}
