<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'number' => $this->number,
            'shipping-price' => $this->shipping_price ?? "0",
            'total_price' => $this->total_price,
            'products' => $this->getProducts(),
            'user' => [
                'id' => $this->user->id,
                'name' => $this->user->first_name,
                'email' => $this->user->email,
                'address' => $this->user->address,
                // Add other user fields as needed
            ],
            'order-status-id' => $this->orderStatus->id,
            'order-status' => $this->orderStatus->getCurrentNameLangAttribute(),
        ];


    }

    private function getProducts()
    {
        return $this->orderItems->map(function ($orderItem) {
            return [
                'product' => new ProductsResource($orderItem->product),
                'quantity' => $orderItem->quantity,
            ];
        });
    }
}
