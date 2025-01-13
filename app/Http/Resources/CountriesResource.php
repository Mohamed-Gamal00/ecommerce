<?php

namespace App\Http\Resources;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $cities = City::where('country_id', $this->id)
            ->where('status', 'used')
            ->get()->map(function ($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name_ar,
                    'shipping_price' => $city->shipping_price ?? "0.00"
                ];
            })->toArray();

        return [
            'id' => $this->id,
            'name' => $this->name_ar,
            'phone_code' => $this->phone_code,
            'cities' => $cities,
        ];
    }
}
