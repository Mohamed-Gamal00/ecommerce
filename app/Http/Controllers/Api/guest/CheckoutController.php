<?php

namespace App\Http\Controllers\Api\guest;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\SendNewsToUser;
use App\Models\Setting;
use App\Models\ShippingTypesAndPrice;
use App\Models\UserAddress;
use App\Notifications\OrderCreatedEmailAdmin;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    public function guestCheckout(Request $request, Order $order)
    {
        $settings = Setting::first();
        $valueAddedTax = $settings->value_added_tax ?? null;

        $guestId = $request->headers->get('guest-id');
//        return $guestId;
        $isAddingNewAddress = !$request->has('user_address');
        if ($guestId) {
            $request->validate([
                'user_address' => $isAddingNewAddress ? 'nullable' : 'required',
                'terms' => 'required|boolean',
                'first_name' => $isAddingNewAddress ? 'required' : 'nullable',
                'last_name' => $isAddingNewAddress ? 'required' : 'nullable',
                'phone_number' => $isAddingNewAddress ? 'required' : 'nullable',
                'country_id' => $isAddingNewAddress ? 'required' : 'nullable',
                'city_id' => $isAddingNewAddress ? 'required' : 'nullable',
                'address' => $isAddingNewAddress ? 'required' : 'nullable',
            ], [
                'user_address.required' => 'Please select or add a new address',
                'first_name.required' => 'First name is required for the new address',
                'last_name.required' => 'Last name is required for the new address',
                'phone_number.required' => 'Phone number is required for the new address',
                'country_id.required' => 'Country is required for the new address',
                'city_id.required' => 'City is required for the new address',
                'address.required' => 'Address is required for the new address',
            ]);
        }


        if ($request->has('shipping_price') && ($request->shipping)) {
            return response()->json(['message' => 'لا يمكن تحديد اكثر من نوع شحن معا'], 422);
        }

        /*طرق الشحن*/
        $shipping = ShippingTypesAndPrice::find(1);
        $selectedShippingOptions = 0;
        $shipping_price = 0;
        if ($request->has('pickup_from_store')) {
            $selectedShippingOptions++;
        }

        if ($request->has('fixed_shipping')) {
            $selectedShippingOptions++;
        }

        if ($request->has('shipping_based_on_weight')) {
            $selectedShippingOptions++;
        }

        if ($request->has('shipping_based_on_city')) {
            $selectedShippingOptions++;
        }
        if ($selectedShippingOptions > 1) {
            return response()->json([
                'error' => 'لا يمكن اختيار اكثر من طريقة شحن في اّن واحد'
            ], 400);
        }

        /*calc shipping price based on shipping selected*/
        if ($request->has('pickup_from_store') && $shipping->add_pickup_from_store == 1) {
            $shipping_price = 0;
        }//
        // سعر شحن ثابت
        elseif ($request->has('fixed_shipping') && $request->fixed_shipping == 1 && $shipping->add_normal_price == 1) {
            $shipping_price = $shipping->normal_shipping_price;
        } //
        // شحن بناء علي الوزن
        elseif ($request->has('shipping_based_on_weight') && $request->shipping_based_on_weight == 1 && $shipping->add_wight_price == 1) {
            $Cartitems = Cart::withoutGlobalScope('cookie_id')
                ->where('user_id', $user->id)
                ->where('status', 0)->get();

            $productWeight = [];

            foreach ($Cartitems as $item) {
                // Calculate the weight of each product multiplied by its quantity
                $productWeight[] = $item->product->weight * $item->quantity;
            }

            $shipping_price = array_sum($productWeight) * $shipping->weight_price;
        } //
        // شحن بناء علي المدينة
        elseif ($request->has('shipping_based_on_city') && $request->shipping_based_on_city == 1 && $shipping->add_price_based_on_city == 1) {
            if ($isAddingNewAddress) {
                $city_id = $request->city_id;
                $city = City::where('id', $city_id)->first();
                $shipping_price = $city->shipping_price;
            } else {
                $UserAddress = UserAddress::where('id', $request->user_address)->first();
                if ($UserAddress) {
                    $shipping_price = $UserAddress->city->shipping_price;
//                    return $city;
                }
            }
        } ///
        else {
            return ApiResponse::sendResponse(200, 'هذه الخدمة غير مفعلة');
        }

//        return $request->all();

//        return $request->all();
        $items = Cart::withoutGlobalScope('cookie_id')
            ->where('guest_id', $guestId)
            ->where('status', 0)->get();

        if ($items->isEmpty()) {
            return ApiResponse::sendResponse(200, 'لا يمكن اتمام الطلب والسلة فارغة');
        }
//        return $guestId;

        DB::beginTransaction();
        try {

            $order = Order::create([
                'guest_id' => $guestId,
                'payment_method' => $request->payment_method, // cash on deleviry
                'order_status_id' => OrderStatus::select('id')->where('default_status', true)->first()->id,
                'note' => $request->note,
                'shipping_price' => request()->pickup_from_store == '1' ? null : $shipping_price,
                'totalBeforeDiscount' => $this->totalBeforeDiscount($guestId),
                'total_price' => $this->total($guestId) + ($this->total($guestId) * ($valueAddedTax / 100)),
                'cookie_id' => $guestId ? null : Cart::getCookieId() // TODO:: what is this used for ?
            ]);

//            return $order;
//            return $items;

            /* items of cart items */
            foreach ($items as $cart_items) {
                // العناصر اللي في السلة هعمل بيها اوردر
                $item = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cart_items->product_id,
                    'product_name' => $cart_items->product->name, // product is the relation
                    'price' => $cart_items->product->price * $cart_items->quantity, // product is the relation
                    'quantity' => $cart_items->quantity,
                    'color' => $cart_items->color_id ?? null,
                ]);

                # NOTE:: Ensure that the user cannot add more items to the cart than the available quantity of the product.
                $product = Product::where('id', $item->product_id)->first();
                Product::where('id', $item->product_id)->update([
                    'quantity' => $product->quantity - $item->quantity
                ]);
//                return $request->all();
                # TODO:: make sure that user will use one option for address

                if ($isAddingNewAddress) {
                    $addressData['type'] = 'shipping';
                    $addressData['first_name'] = $request->first_name;
                    $addressData['last_name'] = $request->last_name;
                    $addressData['phone_number'] = $request->phone_number;
                    $addressData['country_id'] = $request->country_id;
                    $addressData['city_id'] = $request->city_id;
                    $addressData['address'] = $request->address;
                    $order->addresses()->create($addressData);
                }
            }

            foreach ($items as $item) {
                $product = Product::where('id', $item->product_id)->first();
                # TODO::check what is this mean ? check product quantity after checkout
                if ($product->quantity <= 1) {
                    $product->update([
                        'status' => 'archived'
                    ]);
                }
            }


            $admins = Admin::all();
            Notification::send($admins, new OrderCreatedNotification($order));

            $validAdmins = $admins->filter(function ($admin) {
                return filter_var($admin->email, FILTER_VALIDATE_EMAIL);
            });

            foreach ($validAdmins as $admin) {
                try {
                    Notification::route('mail', $admin->email)
                        ->notify(new OrderCreatedEmailAdmin($order));
                } catch (\Exception $e) {
                }
            }


            Cart::withoutGlobalScope('cookie_id')->where('guest_id', $guestId)
                ->where('status', 0)
                ->update(['status' => 1]);

            DB::commit();
            if ($request->payment_method == 'card_payment') {

                $paymentLink = route('user.payment', ['order_number' => $order->number]);

                return response()->json([
                    'message' => 'Order created successfully',
                    'payment_url' => $paymentLink
                ], 201);
            } else {
                return response()->json([
                    'message' => 'Order created successfully',
                ], 201);
            }

        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['message' => 'Order creation failed', 'error' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);


    }

    /* السعر قبل الخصم */
    public function totalBeforeDiscount($guestId): float
    {
        return Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('guest_id', $guestId)->where('status', 0)->get()->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
    }

    /* السعر بعد الخصم لو فيه خصم*/
    public function total($guestId): float
    {
        return Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('guest_id', $guestId)->where('status', 0)->get()->sum(function ($item) {
                return $item->quantity * ($item->discounted_price ?? $item->product->price);
            });
    }
}
