<?php

if(!function_exists('getBox')) 
{
    function getBox($key, $value) 
    {
        return \DB::table('boxes')->where($key, $value);
    }
}

if(!function_exists('hasValue')) 
{
    function hasValue($value) 
    {
        return !empty($value) && !is_null($value);
    }
}

if(!function_exists('isCodeExpired')) {
    function isCodeExpired($box) 
    {
        $time_now = \Carbon\Carbon::now();
        $latest_update = \Carbon\Carbon::parse($box->updated_at);
        $expired = ($time_now->diffInMinutes($latest_update) > 30);

        return $expired || $box->isCodeUsed;
    }
}

if(!function_exists('sendSMSMessage')) 
{
    function sendSMSMessage($mobile_number, $message) 
    {
        $basic  = new \Vonage\Client\Credentials\Basic("43bd37db", "yhrY752gCCZmgbff");
        $client = new \Vonage\Client($basic);

        $response = $client->sms()->send(
            new \Vonage\SMS\Message\SMS($mobile_number, 
                'EMail-Box', 
                $message)
        );
        
        $responseMessage = $response->current();
        
        if ($responseMessage->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $responseMessage->getStatus() . "\n";
        }
    }
}