<?php

namespace App\Services\SMSGateways;

use App\Models\Setting;
use GuzzleHttp\Client;
use Exception;

class qyadatSms
{
    public $client;

    public function __construct()
    {
        if (!$this->client) {
            $this->client = new Client();
        }
    }

    public function sendSms($phone, $message, $language = 'en', $model = null)
    {
        dd('stop send now');
        $setting = Setting::first();

        try {
            // API credentials
            $apiKey = $setting->sms_api_key; // Mora API key
            $username = $setting->sms_user_name; // Your username
            $sender = $setting->sernder; // Sender name (owner name)
            $phone_number = $phone; // phone of user who will receive sms
            $sms_content = urlencode($message); //message

            // Construct the Mora API URL
            $url = "https://www.mora-sa.com/api/v1/sendsms?api_key=$apiKey&username=$username&message=$sms_content&numbers=$phone_number&sender=$sender&unicode=e&return=json";

            // Send the GET request to the Mora API
            $response = $this->client->get($url);

            // Get the response body
            $content = $response->getBody()->getContents();

            $xml = (array)simplexml_load_string($content);

            if ($xml[0] == '0') {
                return true;
            } else {

                info("Qyadat error status!");  // log
                return false;
            }

//            // Decode JSON response (Mora API usually returns JSON)
//            $jsonResponse = json_decode($content, true);
//
////            dd($jsonResponse);
//            // Check for success in the response
//            if (isset($jsonResponse['status']) && $jsonResponse['status'] == 'success') {
//                return true;
//            } else {
//                // Log and dump error message for debugging
//                info("Mora API error: " . json_encode($jsonResponse));
//                dd($jsonResponse); // This will stop execution and display the API response
//                return false;
//            }
        } catch (Exception $e) {
            // Log the exception message if the API call fails
            info("Mora API failed to send SMS to $phone: " . $e->getMessage());
            return false;
        }
    }
}
