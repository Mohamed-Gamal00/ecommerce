<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Models\User_verfication;
use App\Models\UserAddress;
use App\Services\SMSGateways\moraSms;
use App\Services\VerificationServices;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



class UserAuthController extends Controller
{
    public $sms_service;
    public $moraSms;

    public function __construct(VerificationServices $services, moraSms $moraSmsGateway)
    {
        $this->sms_service = $services;
        $this->moraSms = $moraSmsGateway;
    }

    public function register(RegisterRequest $request)
    {


        $user = null;

        try {
            DB::transaction(function () use ($request, &$user) {
                $user = User::create([
                    'first_name' => $request->first_name,
                    'family_name' => $request->family_name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'address' => $request->address
                ]);
                UserAddress::create([
                    'address_title' => 'العنوان الأساسي',
                    'first_name' => $user->first_name,
                    'family_name' => $user->family_name,
                    'phone_number' => $user->phone_number,
                    'user_id' => $user->id,
                    'address' => $request->address,
                    'country_id' => 178,
                    'city_id' => $request->city_id,
                    'main_address' => true
                ]);
            });

            // Generate the verification code and SMS
            $verificationData = $this->sms_service->setVerificationCode($user->id);
            $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
            // $smsSent = $this->moraSms->send_sms($user->phone_number, $message);

           $smsSent = true;

            if ($smsSent) {
                return response()->json([
                    'message' => translateWithHTMLTags("تم ارسال كود التحقق الي رقمك"),
                    'verification_required' => true,
                    'user_id' => $user->id,  // Send back user id for further verification process
                ]);
            } else {
                return response()->json([
                    'message' => 'Failed to send verification SMS. Please try again.',
                ], 500);
            }

        } catch (Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'An Error Occurred While Creating Account',
            ], 500);
        }
    }

    public function verifyCode(Request $request)
    {

        $verificationData = $request->validate([
            'user_id' => 'required',
            'code' => 'required',
        ]);

        $user = User::find($verificationData['user_id']);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        /*check expired code*/
        $user_verificationCode = User_verfication::where('user_id', $user->id)->first();
        if ($user_verificationCode->verification_code_expires_at && now()->greaterThan($user_verificationCode->verification_code_expires_at)) {
            return ApiResponse::sendResponse(403, "انتهت صلاحية رمز التحقق. يرجى طلب واحد جديدة.");
        }

        $isValidCode = $this->sms_service->checkOTPCodePassword($user->id, $verificationData['code']);

        if ($isValidCode) {

            User_verfication::where('user_id', $user->id)
                ->where('code', $verificationData['code']) // Ensure it updates the correct code
                ->update(['is_verified' => true]);

            $token = $user->createToken('-AuthToken')->plainTextToken;
            return response()->json([
                'message' => 'Verification successful',
                'access_token' => $token,
            ]);
        } else {
            return response()->json(['message' => 'Invalid verification code'], 401);
        }
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();
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


        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('-AuthToken')->plainTextToken;
            $data = [
                'token' => $token,
            ];

            return ApiResponse::sendResponse(200, 'Login Successfully', $data);
        }

        return ApiResponse::sendResponse(401, 'Login Failed', []);
    }


    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
            "message" => "logged out"
        ]);
    }

    public function forgetPassword(Request $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();
        if (!$user) {
            return ApiResponse::sendResponse(200, 'this phone_number not exist');
        }

        // Generate the verification code and SMS
        $verificationData = $this->sms_service->setVerificationCode($user->id);
        $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
        // $smsSent = $this->moraSms->send_sms($user->phone_number, $message);

       $smsSent = true;

        if ($smsSent) {
            return response()->json([
               'message' => "$message",
                'verification_required' => true,
                'user_id' => $user->id,  // Send back user id for further verification process
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to send verification SMS. Please try again.',
            ], 500);
        }
    }


    public function resetPassword(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $isValidCode = $this->sms_service->checkOTPCodePassword($user->id, $request->code_verify);
        if ($isValidCode) {
            $request->validate(['password' => 'required|string|min:6|confirmed']);
            $user->update(['password' => $request->password]);
            return response()->json(['message' => 'Password reset successfully.'], 200);

        } else {
            return response()->json(['message' => 'Invalid verification code'], 401);
        }
    }

    public function resendVerifyCode(Request $request)
    {
        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return ApiResponse::sendResponse(422, "Validation Error", $validator->errors());
        }

        $user_id = $request->user_id;
        $user = User::find($user_id);
        if (!$user) {
            return 'user id not found';
        }

        return $this->handleTelephoneVerification($user);
    }

    public function handleTelephoneVerification($user)
    {
        $verificationData = $this->sms_service->setVerificationCode($user->id);
        $message = $this->sms_service->getSMSVerifyMessageByAppName($verificationData->code);
        // $smsSent = $this->moraSms->send_sms($user->telephone, $message);
       $smsSent = true;

        if ($smsSent) {
            $data = ['user_id' => $user->id];
            return ApiResponse::sendResponse(200, translateWithHTMLTags("تم ارسال كود التحقق الي رقمك"), $data);
        } else {
            return ApiResponse::sendResponse(500, "Failed to send verification SMS. Please try again.");
        }
    }

}
