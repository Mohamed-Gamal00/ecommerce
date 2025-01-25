<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Models\User;
use App\Models\User_verfication;
use App\Services\SMSGateways\moraSms;
use App\Services\SMSGateways\TelephoneVerification;
use App\Services\UserService;
use App\Services\VerificationServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{
    protected $sms_service;
    protected $moraSms;
    protected $userService;
    protected $telephoneVerification;

    public function __construct(VerificationServices $services, moraSms $moraSmsGateway, TelephoneVerification $telephoneVerification, UserService $userService)
    {
        $this->sms_service = $services;
        $this->moraSms = $moraSmsGateway;
        $this->userService = $userService;
        $this->telephoneVerification = $telephoneVerification;
    }

    public function register(RegisterRequest $request)
    {
        $user = null;

        $user = $this->userService->createUser($request);

        $data = [
            'verification_required' => true,
            'user_id' => $user->id,
        ];
        return $this->telephoneVerification->SendVerificationCode($user, $data);
    }

    public function verifyCode(Request $request)
    {
        $verificationData = $request->validate([
            'user_id' => 'required',
            'code' => 'required',
        ]);

        $user = User::find($verificationData['user_id']);

        if (!$user) {
            return ApiResponse::sendResponse(404, "User not found");
        }
        /*check expired code*/
        if ($this->userService->isVerificationCodeExpired($user)) {
            return ApiResponse::sendResponse(403, "انتهت صلاحية رمز التحقق. يرجى طلب واحد جديدة.");
        }

        $isValidCode = $this->sms_service->checkOTPCodePassword($user->id, $verificationData['code']);

        if ($isValidCode) {
            $this->userService->markUserVerified($user, $request->code);
            $token = $user->createToken('-AuthToken')->plainTextToken;
            $data = [
                'token' => $token,
            ];

            return ApiResponse::sendResponse(200, 'Verification successful', $data);
        } else {
            return ApiResponse::sendResponse(403, 'Invalid verification code');
        }
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();
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
        auth()->user()->currentAccessToken()->delete();
        return ApiResponse::sendResponse(200, 'logged out');
    }

    public function forgetPassword(Request $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();
        if (!$user) {
            return ApiResponse::sendResponse(200, 'this phone_number not exist');
        }
        $data = [
            'verification_required' => true,
            'user_id' => $user->id,
        ];
        return $this->telephoneVerification->SendVerificationCode($user, $data);
    }


    public function resetPassword(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if ($this->userService->isVerificationCodeExpired($user)) {
            return ApiResponse::sendResponse(403, "انتهت صلاحية رمز التحقق. يرجى طلب واحد جديدة.");
        }

        $isValidCode = $this->sms_service->checkOTPCodePassword($user->id, $request->code_verify);
        if ($isValidCode) {
            $request->validate(['password' => 'required|string|min:6|confirmed']);
            $user->update(['password' => $request->password]);
            return ApiResponse::sendResponse(200, 'Password reset successfully.');
        } else {
            return ApiResponse::sendResponse(200, 'Invalid verification code');
        }
    }

    public function resendVerifyCode(Request $request)
    {
        $validator = Validator::make($request->all(), [
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

        $data = ['user_id' => $user->id];
        return $this->telephoneVerification->SendVerificationCode($user, $data);
    }
}
