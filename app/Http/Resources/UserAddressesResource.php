<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressesResource extends JsonResource
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
            'main_address' => $this->main_address,
            'title' => $this->address_title,
            'first_name' => $this->first_name,
            'family_name' => $this->family_name,
            'address' => $this->address,
            'city' => $this->city->name_ar,
            'city_id' => $this->city->id,
            'address_phone_number' => '+' . $this->country->phone_code . ' ' . $this->phone_number
        ];
    }
}
