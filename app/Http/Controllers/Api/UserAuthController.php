<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Mail\PasswordResetCodeMail;
use App\Models\ForgetPassword;
use App\Models\User;
use App\Models\UserAddress;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Actions\CompletePasswordReset;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\FailedPasswordResetResponse;
use Laravel\Fortify\Contracts\PasswordResetResponse;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Fortify;

use Illuminate\Support\Str;


class UserAuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $data = [];
        try {

            DB::transaction(function () use ($request, &$data) {
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
                $data['token'] = $user->userToken->token;
            });


        } catch (Exception $e) {
            return ApiResponse::sendResponse(500, 'An Error Occurred While Create Account');
        }

        return ApiResponse::sendResponse(201, 'Account Created Successfully', $data);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $this->createToken($user);
            $data = [
                'email' => $user->email,
                'token' => $token,
            ];

            return ApiResponse::sendResponse(200, 'Login Successfully', $data);
        }

        return ApiResponse::sendResponse(401, 'Login Failed', []);
    }

    private function createToken($user)
    {

        $token = encrypt(Str::random(30));
        $user->userToken()->create([
            'token' => $token,
        ]);

        return $token;
    }

    public function logout(Request $request)
    {
        $user = $request->user();


        $this->deleteToken($user);

        return ApiResponse::sendResponse(200, 'Logout Successfully', []);
    }

    private function deleteToken($user)
    {
        $user->userToken()->delete();


    }

    public function forgetPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return ApiResponse::sendResponse(200, 'this email not exist');
        }
        // Generate UUID and unique code
        $uuid = Str::uuid()->toString();
        $code = Str::random(6); // Generates a random 6-character string

        ForgetPassword::create([
            'uuid' => $uuid,
            'user_id' => $user->id,
            'code' => $code,
        ]);
        // Send the code to the user's email
        // Mail::to($request->email)->send(new PasswordResetCodeMail($code));
        return ApiResponse::sendResponse(200, 'Reset code sent to your email.', $code);
    }

    public function resetPassword(Request $request)
    {
        $request->validate(['code' => 'required', 'new_password' => 'required']);

        $record = ForgetPassword::where('code', $request->code)->first();

        if (!$record || Carbon::parse($record->created_at)->addMinutes(5)->isPast()) {
            return response()->json(['message' => 'Reset code is invalid or expired.'], 400);
        }

        // Reset the user's password
        $user = User::find($record->user_id);
        $user->update(['password' => $request->new_password]);

        // Optionally, delete the record after successful password reset
        $record->delete();

        return response()->json(['message' => 'Password reset successfully.'], 200);
    }

    /**
     * Get the broker to be used during password reset.
     *
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }

}