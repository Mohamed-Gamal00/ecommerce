<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TopProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'category' => $this->parent->name,
            'current_price' => $this->price,
            'price_before_discount' => $this->discount_price,
            'image' => $this->image_url,
            'product_status' => $this->availability->name,
        ];
    }
}
