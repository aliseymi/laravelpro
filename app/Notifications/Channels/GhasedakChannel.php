<?php

namespace App\Notifications\Channels;

use Ghasedak\Exceptions\ApiException;
use Ghasedak\Exceptions\HttpException;
use Illuminate\Notifications\Notification;

class GhasedakChannel
{
    public function send($notifiable, Notification $notification)
    {
        if(! method_exists($notification,'toGhasedakSms')){
            throw new \Exception('toGhasedakSms not found!');
        }

        $data = $notification->toGhasedakSms($notifiable);
        $message = $data['text'];
        $receptor = $data['phone_number'];

        $api_key = config('services.ghasedak.key');
        try
        {
            $lineNumber = "10008566";
            $api = new \Ghasedak\GhasedakApi($api_key);
            $api->SendSimple($receptor,$message,$lineNumber);
        }
        catch(ApiException $e){
            throw $e;
        }
        catch(HttpException $e){
            throw $e;
        }
    }
}
