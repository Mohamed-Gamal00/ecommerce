<?php

namespace App\Services\SMSGateways;

use App\Helper\ApiResponse;

use App\Services\VerificationServices;

class TelephoneVerification
{
    protected $sms_service;
    protected $moraSms;

    public function __construct(VerificationServices $services, moraSms $moraSmsGateway)
    {
        $this->sms_service = $services;
        $this->moraSms = $moraSmsGateway;
    }

    public function SendVerificationCode($user, $data)
    {
        $verificationData = $this->sms_service->setVerificationCode($user->id);
        $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
        $smsSent = true;

        if ($smsSent) {
            return ApiResponse::sendResponse(200, translateWithHTMLTags($message), $data);
        } else {
            return ApiResponse::sendResponse(500, "Failed to send verification SMS. Please try again.");
        }
    }
}
