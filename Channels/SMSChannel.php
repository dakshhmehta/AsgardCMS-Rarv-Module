<?php

namespace Modules\Rarv\Channels;

use Illuminate\Notifications\Notification;

class SMSChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSMS($notifiable);

        // First attempt to use the URL provided in setting, if not provided, 
        // fall back to use from config file, which is RI's API link.
        $api_url = setting('rarv::sms_http_api_url', null, false);
        if ($api_url == false) {
            $api_url = config('asgard.rarv.config.sms_api_url');
        }


        $api_url = str_replace('##mobileNo##', $message->getMobileNo(), $api_url);
        $api_url = str_replace('##senderId##', setting('rarv::sender_id'), $api_url);
        $api_url = str_replace('##apiKey##', setting('rarv::api_key'), $api_url);
        $api_url = str_replace('##message##', urlencode($message->getMessage()), $api_url);

        \Log::debug($api_url);

        // Get cURL resource
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_PORT           => "80",
            CURLOPT_URL            => trim($api_url),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => "",
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => "GET",
            CURLOPT_HTTPHEADER     => array(
                "Cache-Control: no-cache",
            ),
        ));

        $response = curl_exec($curl);
        $err      = curl_error($curl);

        curl_close($curl);

        \Log::debug('SMS Response '.$response);
        \Log::debug('SMS Error '.$err);

        return $response;
    }
}
