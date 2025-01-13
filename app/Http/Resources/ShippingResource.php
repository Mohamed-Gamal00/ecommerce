<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'pickup-from-store' => $this->add_pickup_from_store,
            'shipping-based-on-weight' => $this->add_wight_price,
            'shipping-weight-price' => $this->weight_price,
            'fixed-shipping' => $this->add_normal_price,
            'fixed-shipping-price' => $this->normal_shipping_price,
            'shipping-based-on-city' => $this->add_price_based_on_city,
        ];
    }
}
