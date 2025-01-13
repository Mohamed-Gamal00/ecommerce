<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'name' => $this->product->getCurrentNameLangAttribute(),
            'image' => $this->product->image_url,
            'category' => $this->product->parent->getCurrentNameLangAttribute(),
            'current_price' => $this->product->price,
            'quantity' => $this->quantity,
            'weight' => $this->product->weight,
            'price_before_discount' => $this->product->price_before_discount,
            'product_status' => $this->product->availability->getCurrentNameLangAttribute(),
        ];
    }
}
