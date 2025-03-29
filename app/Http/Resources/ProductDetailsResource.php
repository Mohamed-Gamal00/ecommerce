<?php

namespace App\Http\Resources;

use App\currency\Currency;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Helper\Helper;

class ProductDetailsResource extends JsonResource
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
            'choices' => $this->choices->map(function ($choice) {
                return [
                    'id' => $choice->id,
                    'name' => $choice->getCurrentNameLangAttribute(),
                    'sub_choices' => $choice->children->map(function ($subChoice) {
                        return [
                            'id' => $subChoice->id,
                            'name' => $subChoice->getCurrentNameLangAttribute(),
                        ];
                    }),
                ];
            }),
            'price_before_discount' => preg_replace('/[A-Z]+/', '', strval(Currency::getCurrencyApi($this->price))),
            'price_after_discount' => preg_replace('/[A-Z]+/', '', strval(Currency::getCurrencyApi($this->discount_price))),
            'currency' => preg_replace('/[0-9.]+/', '', strval(Currency::getCurrencyApi($this->discount_price))),
            'description' => translateWithHTMLTags($this->description),
            'image' => $this->image_url,
            'more_images' => $this->images->take(3)->pluck('image_url')->toArray(),
            'is_favourite' => $this->checkIfProductExists($request, $this->id),
        ];
    }
}
