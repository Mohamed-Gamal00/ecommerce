<?php

namespace App\Http\Resources;

use App\currency\Currency;
use App\Helper\Helper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ViewProductsResource extends JsonResource
{
    use Helper;

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
            'category' => [
                'id' => $this->parent->id,
                'name' => $this->parent->getCurrentNameLangAttribute(),
            ],
            'price_before_discount' => preg_replace('/[A-Z]+/', '', strval(Currency::getCurrencyApi($this->price))),
            'price_after_discount' => preg_replace('/[A-Z]+/', '', strval(Currency::getCurrencyApi($this->discount_price))),
            'currency' => preg_replace('/[0-9.]+/', '', strval(Currency::getCurrencyApi($this->discount_price))),
            'image' => $this->image_url,
            'product_status' => $this->availability->getCurrentNameLangAttribute(),
            'is_favourite' => $this->checkIfProductExists($request, $this->id),

        ];
    }
}