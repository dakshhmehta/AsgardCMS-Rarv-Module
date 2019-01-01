<?php

namespace Modules\Rarv\Channels;

use Illuminate\Notifications\Notification;
use Modules\Rarv\CUrl;

class SMSChannel
{
	public function send($notifiable, Notification $notification)
	{
		$message = $notification->toSMS($notifiable);

        $api_url = config('asgard.rarv.config.sms_api_url');

        $api_url = str_replace('##mobileNo##', $message->getMobileNo(), $api_url);
        $api_url = str_replace('##senderId##', setting('rarv::sender_id'), $api_url);
        $api_url = str_replace('##apiKey##', setting('rarv::api_key'), $api_url);
        $api_url = str_replace('##message##', $message->getMessage(), $api_url);


        \Log::debug($api_url);

        // Get cURL resource
        $curl = new CUrl;
        $curl->to($api_url);
        $resp = $curl->get();

        \Log::debug($resp);

        return $resp;
	}
}