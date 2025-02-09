<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CheckDiscountCode;
use App\Services\Discount\CheckDiscountService;

class CheckDiscountController extends Controller
{
    protected $checkDiscountCode;
    public function __construct(CheckDiscountService $checkDiscount)
    {
        $this->checkDiscountCode = $checkDiscount;
    }
    public function __invoke(CheckDiscountCode $request)
    {
        $discountCode = $this->checkDiscountCode->fetchDiscountCode($request);

        if (!$discountCode) {
            return ApiResponse::sendResponse(400, 'لقد انتهت صلاحية رمز الخصم هذا أو لم يعد صالحًا.');
        }

        $userUsedDiscountCode = $this->checkDiscountCode->checkIfUserUseDiscountCode($discountCode);
        if ($userUsedDiscountCode) {
            return $userUsedDiscountCode;
        }

        // Decrement the number of uses for this discount code
        $discountCode->decrement('number_of_used');

        // بشوف لو كود الخصم مش متحدد لمنتجات معينة هيبقي خصم علي كل المنتجات
        $isGlobalDiscount = $discountCode->products()->count() === 0;

        $user = $request->user();

        // Apply discount to cart items
        return $this->checkDiscountCode->applyDiscountToCartItems($discountCode, $isGlobalDiscount, $user);

    }
}
