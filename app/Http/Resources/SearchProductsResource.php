<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SearchProductsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->id,
            'product_name' => $this->name,
            'category' => [
                'category_id' => $this->parent->id,
                'category_name' => $this->parent->id,
            ],
            'current_price' => $this->price,
            'price_before_discount' => $this->discount_price,
            'image' => $this->image_url,
            'product_status' => $this->availability->name,
        ];
    }
}
