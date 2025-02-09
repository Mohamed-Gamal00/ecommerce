<?php

namespace App\Services\Discount;

use App\Helper\ApiResponse;
use App\Models\Cart;
use App\Models\DiscountCode;
use App\Models\UserDiscountCode;

class CheckDiscountService
{
    public function fetchDiscountCode($request)
    {
        return DiscountCode::where('code', $request->discount_code)
            ->where('status', 'active')
            ->where('number_of_used', '>', 0)
            ->first();
    }

    public function checkIfUserUseDiscountCode($discountCode)
    {
        $userDiscountCodeExists = UserDiscountCode::where([
            'cookie_id' => Cart::getCookieIdApi(),
            'discount_id' => $discountCode->id
        ])->exists();

        if ($userDiscountCodeExists) {
            return ApiResponse::sendResponse(400, 'لقد استخدمت هذا الكود بالفعل.');
        }
        UserDiscountCode::create([
            'cookie_id' => Cart::getCookieIdApi(),
            'discount_id' => $discountCode->id
        ]);

        return null;
    }

    public function applyDiscountToCartItems($discountCode, $isGlobalDiscount, $user)
    {
        $cartItems = Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('status', 0)->get();

        if ($cartItems->isEmpty()) {
            return ApiResponse::sendResponse(200, 'لا يمكن استخدام كود الخصم والسلة فارغة');
        }

        foreach ($cartItems as $item) {
            // موجودة في السلة $discountCode->products لو المنتجات اللي عليها خصم
            if ($isGlobalDiscount || $discountCode->products->contains($item->product_id)) {
                // Apply discount based on discount type نوع الخصم اذا كان نسبة او ثابت
                if ($discountCode->discount_type == 'percentage') {
                    $discountAmount = (($item->product->discount_price ?? $item->product->price) * $discountCode->price) / 100;
                } else {
                    $discountAmount = $discountCode->price;
                }
                // نسبة الخصم علي المنتج الواحد
                $originalPrice = $item->product->discount_price ?? $item->product->price;
                $item->discounted_price = max(0, $originalPrice - $discountAmount);
                $item->save();
            }
        }

        $data = [
            'discount_code' => $discountCode->code,
            'discount_price' => $discountCode->price,
        ];
        return ApiResponse::sendResponse(200, 'success', $data);
    }
}
