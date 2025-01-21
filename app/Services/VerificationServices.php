<?php

namespace App\Services;

use App\Models\User;
use App\Models\User_verfication;
use Illuminate\Support\Facades\Auth;


class VerificationServices
{
    /** set OTP code for mobile
     * @param $data
     *
     * @return User_verfication
     */
    public function setVerificationCode($userId, $isResetPassword = false)
    {
        $code = mt_rand(1000, 9999);
        // $expiresAt = now()->addMinutes(5);
        $expiresAt = now()->addSeconds(60);
        $oldCode = User_verfication::where('user_id', $userId)->where('is_reset_password', $isResetPassword)->first();
        $newCode = User_verfication::updateOrCreate([
            'id' => $oldCode ? $oldCode->id : null
        ], [
            'user_id' => $userId,
            // 'code' => $code,
            'code' => 1111,
            'is_reset_password' => $isResetPassword,
            'verification_code_expires_at' => $expiresAt,

        ]);

        return $newCode;
    }

    public function getSMSVerifyMessageByAppName($code)
    {
        $setting = \App\Models\Setting::select('website_name', 'website_name_en')->first();
        $message = $setting->CurrentNameLang . "  رمز التحقق الخاص بحسابك ";
        return $message . $code;
    }

    public function getSMSVerifyNewUserPasswordByAppName($code)
    {
        $setting = \App\Models\Setting::select('website_name')->first();
        $message = "https://masareltamleek.com/ تم انشاء حسابك لدى مسار التمليك بنجاح يمكنك الدخول لحسابك من خلال رقم جوالك المسجل وكلمة المرور";
        return $message . $code;
    }

    public function getSMSVerifyPasswordMessageByAppName($code)
    {
        $setting = \App\Models\Setting::select('website_name')->first();
        $message = $setting->website_name . " رمز التحقق الخاص بتغير كلمه المرور ";
        return $message . $code;
    }

    public function getSMSVerifyActiveMemberMessageByAppName($sitename)
    {
        $message = " تم تفعيل حسابك في ";
        return $message . $sitename;
    }

    public function getSMSVerifyFundMemberMessageByAppName($sitename)
    {
        $message = " تم قبول طلب التمويل من اداره منصه ";
        return $message . $sitename;
    }

    public function getSMSVerifyFincialMemberMessageByAppName($sitename, $order_number, $type)
    {
        $message = $type . 'الي  ' . $order_number . 'تم نقل طلبك رقم ';
        return $message . $sitename;
    }

    public function getSMSVerifyFundemployMessageByAppName()
    {
        $message = " تم قبول طلبك من قبل جهة التمويل ";
        return $message;
    }


    public function checkOTPCode($code)
    {

        if (Auth::guard()->check()) {
            $verificationData = User_verfication::where('user_id', Auth::id())->first();
            if ($verificationData) {
                if ($verificationData->code == $code) {
                    User::whereId(Auth::id())->update(['email_verified_at' => now()]);
                    return true;
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    public function checkOTPCodePassword($user_id, $code)
    {

        $verificationData = User_verfication::where('user_id', $user_id)->first();
        if ($verificationData) {
            if ($verificationData->code == $code) {
                return true;
            } else {
                return false;
            }
        }
        return false;
    }


    public function removeOTPCode($code)
    {
        User_verfication::where('code', $code)->delete();
    }
}
