<?php

namespace App\Http\Resources;

use App\Helper\Helper;
use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'profile_image' => $this->image_url,
            'first_name' => $this->first_name,
            'family_name' => $this->family_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'country' => [
                'id' => $this->addresses->first()->country_id,
                'name' => $this->addresses->first()->country->name_ar,
                'country_code' => $this->addresses->first()->country->phone_code,
            ],
        ];
    }
}
