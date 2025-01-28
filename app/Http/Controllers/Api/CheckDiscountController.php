<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\DiscountCode;
use App\Models\UserDiscountCode;
use Illuminate\Http\Request;

class CheckDiscountController extends Controller
{
    public function __invoke(Request $request)
    {


        // Validate the request
        $request->validate([
            'discount_code' => 'required|exists:discount_codes,code'
        ]);

        // Fetch the discount code and check its validity
        $discountCode = DiscountCode::where('code', $request->discount_code)
            ->where('status', 'active')
            ->where('number_of_used', '>', 0)
            ->first();
        //        return $discountCode;

        if (!$discountCode) {
            return response()->json([
                'message' => 'لقد انتهت صلاحية رمز الخصم هذا أو لم يعد صالحًا.'
            ], 400);
        }
        //        if (str_contains(request()->path(), 'api')) {
        //            return Cart::getCookieIdApi();
        //        } else {
        //            return 'cuhk';
        //        }

        //        return Cart::getCookieIdApi();
        $userDiscountCode = UserDiscountCode::where([
            'cookie_id' => Cart::getCookieIdApi(),
            'discount_id' => $discountCode->id
        ])->first();

        if ($userDiscountCode) {
            return response()->json([
                'message' => 'لقد استخدمت هذا الكود بالفعل.'
            ], 400);
        } else {
            UserDiscountCode::create([
                'cookie_id' => Cart::getCookieIdApi(),
                'discount_id' => $discountCode->id
            ]);
        }
        // Decrement the number of uses for this discount code
        $discountCode->decrement('number_of_used');

        // بشوف لو كود الخصم مش متحدد لمنتجات معينة هيبقي خصم علي كل المنتجات
        $isGlobalDiscount = $discountCode->products()->count() === 0;

        // Apply discount to eligible cart items
        $user = $request->user();

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

                // Set the discounted price
                // نسبة الخصم علي المنتج الواحد
                
                $originalPrice = $item->product->discount_price ?? $item->product->price;
                $item->discounted_price = max(0, $originalPrice - $discountAmount);
                $item->save();
            }
        }

        return response()->json([
            'message' => 'Discount code applied successfully.',
            'discount_code' => $discountCode->code,
            'discount_price' => $discountCode->price,
            //            'cart' => $cartItems
        ], 200);
    }
}
