<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductColorsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $colorsData = [];

        foreach ($this->colors as $color) {
            $colorsData[] = [
                'id' => $color->id,
                'color_name' => $color->name,
                'color_code' => $color->color_code,
            ];
        }

        return $colorsData;
    }
}
