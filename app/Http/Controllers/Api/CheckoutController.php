<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserCheckoutRequest;
use App\Http\Resources\ShippingResource;
use App\Models\Order;
use App\Models\ShippingTypesAndPrice;
use App\Services\CheckOut\CheckoutServices;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Throwable;

class CheckoutController extends Controller
{
    protected $checkOutservice;

    public function __construct(CheckoutServices $checkOutservices)
    {
        $this->checkOutservice = $checkOutservices;
    }

    public function usercheckout(UserCheckoutRequest $request,  Order $order)

    {

        $user = $request->user();

        // handle requests
        try {

            $this->checkOutservice->checkShippingSelectOptions($request);

            $this->checkOutservice->checkUserAddressOptions($request);

            $shipping_price = $this->checkOutservice->calculateShippingPrice($request, $user);

            $cartItems = $this->checkOutservice->getCartItems($user);

            if ($cartItems->isEmpty()) {
                return ApiResponse::sendResponse(200, 'لا يمكن اتمام الطلب والسلة فارغة');
            }
        } catch (\Exception $e) {
            return ApiResponse::sendResponse(400, $e->getMessage());
        }


        // handle database proccessing
        DB::beginTransaction();
        try {
            $this->checkOutservice->checkJoinNews($request, $user);

            $order = $this->checkOutservice->createOrder($request, $user, $shipping_price);


            $this->checkOutservice->createOrderItems($order, $user);

            $this->checkOutservice->isAddingNewAddress($order, $request, $user);

            $this->checkOutservice->disActiveProduct($cartItems);

            $this->checkOutservice->updateProductStatue($user);

            $this->checkOutservice->sendNotificationToAdmin($order);

            DB::commit();

            return $this->checkOutservice->checkPaymentMethod($request, $order);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Order creation failed', 'error' => $e->getMessage()], 500);
        }
    }

    // public function total($user): float
    // {
    //     /* السعر بعد الخصم لو فيه خصم*/
    //     return Cart::with('product')->withoutGlobalScope('cookie_id')
    //         ->where('user_id', $user->id)->where('status', 0)->get()
    //         ->sum(function ($item) {
    //             if ($item->product->discount_price) {
    //                 return $item->quantity * ($item->discounted_price ?? $item->product->discount_price);
    //             } else {

    //                 return $item->quantity * ($item->discounted_price ?? $item->product->price);
    //             }
    //         });
    // }


    // public function totalBeforeDiscount($user): float
    // {
    //     return Cart::with('product')->withoutGlobalScope('cookie_id')
    //         ->where('user_id', $user->id)->where('status', 0)->get()->sum(function ($item) {
    //             return $item->quantity * $item->product->discount_price ?? $item->product->price;
    //         });
    // }



    public function shippingInfo(Request $request)
    {

        $shipping = ShippingTypesAndPrice::find(1);

        $data = [
            'shipping_info' => new ShippingResource($shipping),
        ];
        return ApiResponse::sendResponse(200, '', $data);
    }
}
