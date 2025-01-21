<?php

namespace App\Http\Controllers\Api\Profile;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserAddressRequest;
use App\Http\Resources\UserAddressesResource;
use App\Http\Resources\UserCitiesResource;
use App\Models\City;
use App\Models\UserAddress;
use Illuminate\Http\Request;

class UserAddressesController extends Controller
{
    public function getAllAddresses()
    {
        $user = request()->user();
        if ($user->has('addresses')) {
            return ApiResponse::sendResponse(200, 'Address Retrieved Successfully', UserAddressesResource::collection($user->addresses));
        }

    }

    public function createAddress(UserAddressRequest $request)
    {
        $user = request()->user();
        $userCountry = $user->addresses->first();

//        return $userCountry;

        $address = UserAddress::create([
            'user_id' => $user->id,
            'address_title' => $request->address_title,
            'first_name' => $request->first_name,
            'family_name' => $request->last_name,
            'address' => $request->address,
            'country_id' => $userCountry->country_id,
            'city_id' => $request->city_id,
            'phone_number' => $request->phone_number
        ]);
        return ApiResponse::sendResponse(200, 'Address Created Successfully', UserAddressesResource::make($address));

    }

    public function updateAddress(UserAddressRequest $request, $id)
    {
        $user = request()->user();
        $address = UserAddress::find($id);
        $userCountry = $user->addresses->first();

        if ($address) {

            $address->update([
                'user_id' => $user->id,
                'address_title' => $request->address_title,
                'first_name' => $request->first_name,
                'family_name' => $request->last_name,
                'address' => $request->address,
                'country_id' => $userCountry->country_id,
                'city_id' => $request->city_id,
                'phone_number' => $request->phone_number
            ]);

            return ApiResponse::sendResponse(200, 'Address Updated Successfully', UserAddressesResource::make($address));
        }
        return ApiResponse::sendResponse(200, 'Address Not Found', []);

    }

    public function deleteAddress($id)
    {
        $address = UserAddress::find($id);

//        return $address;
        if ($address) {
            if ($address->main_address == 1) {
                return ApiResponse::sendResponse(200, 'لا يمكن حذف عنوان رئيسي', []);
            } else {
                $address->delete();
                return ApiResponse::sendResponse(200, 'Address Deleted Successfully', []);

            }

        }
        return ApiResponse::sendResponse(200, 'Address Not Found', []);


    }

    public function getUserCities(Request $request)
    {
        $user = $request->user();

        $userCountry = $user->addresses->first();

        $userCities = City::where('status', 'used')->where('country_id', $userCountry->country_id)->get();

        if (count($userCities) > 0) {
            return ApiResponse::sendResponse(200, 'User\'s Country Cities Retrieved Successfully', UserCitiesResource::collection($userCities));
        }
        return ApiResponse::sendResponse(200, 'No Cities To Retrieved', []);

    }

    public function setMainAddress(Request $request, $id)
    {
        $user = $request->user();
        $addresses = $user->addresses()->get();
        $currentAddress = $user->addresses()->where('id', $id)->first();

        if ($currentAddress) {

            foreach ($addresses as $address) {
                $address->where('main_address', true)->update(['main_address' => false]);
            }

            $user->addresses()->where('id', $id)->first()->update(['main_address' => true]);
            $data = [
                'id' => $currentAddress->id,
                'title' => $currentAddress->address_title
            ];
            return ApiResponse::sendResponse(200, 'Main Address Changed Successfully', $data);

        }
        return ApiResponse::sendResponse(200, 'Address Not Found', []);

    }
}
