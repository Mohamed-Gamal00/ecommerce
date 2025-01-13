<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'website_name' => $this->getCurrentNameLangAttribute(),
            'subscription_title' => $this->subscription_title,
            'address' => $this->address,
            'email' => $this->email,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'snap' => $this->snap,
            'tiktok' => $this->tiktok,
            'tax_number' => $this->tax_number,
            'value_added_tax' => $this->value_added_tax,
            'image' => asset('storage/' . $this->image),
            'logo' => asset('storage/' . $this->logo),
        ];
    }
}
