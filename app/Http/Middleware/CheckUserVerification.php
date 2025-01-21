<?php

namespace App\Http\Middleware;

use App\Services\SMSGateways\moraSms;
use App\Services\VerificationServices;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserVerification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public $sms_service;
    public $moraGateway;

    public function __construct(VerificationServices $services, moraSms $moraSms)
    {
        $this->sms_service = $services;
        $this->moraGateway = $moraSms;
    }

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->verificationCode && !$user->verificationCode->is_verified) {
            // Generate the verification code and SMS
            $verificationData = $this->sms_service->setVerificationCode($user->id);
            $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
            // $smsSent = $this->moraSms->send_sms($user->phone_number, $message);

            $smsSent = true;

            if ($smsSent) {
                return response()->json([
                    'message' => "Your account is not verified. A new verification code has been sent to your phone number.",
                    'verification_required' => true,
                    'user_id' => $user->id,
                ], 403);
            } else {
                return response()->json([
                    'message' => 'Failed to send verification SMS. Please try again later.',
                ], 500);
            }
        }

        // Allow the request to continue to the next middleware or controller
        return $next($request);
    }
}
