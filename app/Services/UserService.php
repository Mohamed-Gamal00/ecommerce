<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserAddress;
use App\Models\User_verfication;
use App\Services\SMSGateways\moraSms;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
    public function createUser($request)
    {
        $user = null;

        try {
            DB::transaction(function () use ($request, &$user) {
                // Create the user
                $user = User::create([
                    'first_name' => $request->first_name,
                    'family_name' => $request->family_name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'address' => $request->address
                ]);

                // Create the user's address
                UserAddress::create([
                    'address_title' => 'العنوان الأساسي',
                    'first_name' => $user->first_name,
                    'family_name' => $user->family_name,
                    'phone_number' => $user->phone_number,
                    'user_id' => $user->id,
                    'address' => $request->address,
                    'country_id' => 178, // Assuming default country is 178 (Saudi Arabia)
                    'city_id' => $request->city_id,
                    'main_address' => true
                ]);
            });
        } catch (Exception $e) {
            throw new Exception("Error creating user and address: " . $e->getMessage());
        }

        return $user;
    }

    public function isVerificationCodeExpired($user)
    {
        $user_verificationCode = User_verfication::where('user_id', $user->id)->first();

        if ($user_verificationCode && $user_verificationCode->verification_code_expires_at) {
            return now()->greaterThan($user_verificationCode->verification_code_expires_at);
        }

        return false;
    }

    public function markUserVerified($user, $code)
    {
        User_verfication::where('user_id', $user->id)
            ->where('code', $code)
            ->update(['is_verified' => true]);
    }

}
