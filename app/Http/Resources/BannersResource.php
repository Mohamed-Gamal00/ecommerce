<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BannersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'desc' => $this->getDescription($this->title),
            'image_url' => asset('storage/' . $this->image),
        ];
    }

    protected function getDescription(string $title): string
    {
        // Add your logic here to check the title and return the corresponding description
        if ($title === 'banner1') {
            return 'خصومات تصل 40 %.';
        } elseif ($title === 'banner2') {
            return 'خصومات تصل 40 %';
        } elseif ($title === 'banner3') {
            return 'عروض وتخفيضات علي علي مستلزمات المطبخ';
        } elseif ($title === 'banner4') {
            return 'خصومات تصل 40 %';
        } elseif ($title === 'banner5') {
            return 'خصومات تصل 40 %';
        } elseif ($title === 'discount1') {
            return 'خصومات تصل 40 %';
        } elseif ($title === 'discount2'
        ) {
            return 'خصومات تصل 40 %';
        } else {
            return 'This is a general banner description.';
        }
    }
}
