<?php

namespace App\Http\Controllers\Api\Profile;

use App\Helper\ApiResponse;
use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePersonalInfoRequest;
use App\Http\Resources\UserInfoResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PersonalInfoController extends Controller
{
    use Helper;

    public function getUserInfo(Request $request)
    {
        $user = $request->user();

        return ApiResponse::sendResponse(200, 'success', UserInfoResource::make($user));
    }

    public function changePersonalInfo(ChangePersonalInfoRequest $request)
    {
        $request->validated();
        $user = $request->user();


        $user->update([
            'first_name' => $request->first_name ?? $user->first_name,
            'family_name' => $request->last_name ?? $user->family_name,
            'phone_number' => $request->phone_number ?? $user->phone_number,
            'email' => $request->email ?? $user->email
        ]);

        $data = [
            'first_name' => $user->first_name,
            'family_name' => $user->family_name,
            'phone_number' => $user->phone_number,
            'email' => $user->email
        ];

        return ApiResponse::sendResponse(200, 'success', $data);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => ['required', 'confirmed', 'min:8']
        ]);

        $user = $request->user();

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return ApiResponse::sendResponse(200, 'success', []);
    }

    public function changeProfileImage(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        
        $user = $request->user();

        $oldImage = $user->image;
        $newImage = $this->uploadedImage(request(), 'image', 'users');

        if ($newImage) {
            $image = $newImage;
        }

        if ($newImage && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        if ($request->image) {
            $user->update([
                'image' => $image
            ]);
        }

        $data = [
            'image' => $user->image_url
        ];

        return ApiResponse::sendResponse(200, 'success', $data);
    }
}
