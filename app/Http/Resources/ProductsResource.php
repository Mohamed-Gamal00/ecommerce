<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductsResource extends JsonResource
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
            'name' => $this->getCurrentNameLangAttribute(),
            'category' => $this->parent->getCurrentNameLangAttribute(),
            'current_price' => $this->price,
            'price_before_discount' => $this->discount_price,
            'image' => $this->image_url,
            'product_status' => $this->availability->getCurrentNameLangAttribute(),
        ];
    }
}
