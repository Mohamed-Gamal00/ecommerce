<?php

namespace App\Services\CheckOut;

use App\Helper\ApiResponse;
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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class CheckoutServices
{

    public function checkJoinNews($request, $user)
    {
        if ($request->join_news) {

            $existingEmail = SendNewsToUser::where('email', $user->email)->first();

            if (!$existingEmail) {
                SendNewsToUser::create(['email' => $user->email]);
            }
        }
    }

    public function checkUserAddressOptions($request)
    {
        if ($request->has('user_address') && ($request->first_name || $request->last_name || $request->phone_number || $request->country_id || $request->city_id || $request->address)) {
            throw new \Exception(translateWithHTMLTags('Please select only one option: either choose an existing address or provide a new address.'), 400);
        }
    }
    public function checkShippingSelectOptions($request)
    {
        $selectedShippingOptions = 0;
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
            throw new \Exception('لا يمكن اختيار اكثر من طريقة شحن في اّن واحد', 400);
        }
    }

    public function calculateShippingPrice($request, $user): float
    {
        $shipping = ShippingTypesAndPrice::find(1);
        $shippingPrice = 0;

        if ($request->has('pickup_from_store') && $shipping->add_pickup_from_store == 1) {
            $shippingPrice = 0;
        }
        // شحن ثابت
        elseif ($request->has('fixed_shipping') && $shipping->add_normal_price == 1) {
            $shippingPrice = $shipping->normal_shipping_price;
        }
        // شحن بناء علي الوزن
        elseif ($request->has('shipping_based_on_weight') && $shipping->add_wight_price == 1) {
            $cartItems = Cart::withoutGlobalScope('cookie_id')
                ->where('user_id', $user->id)
                ->where('status', 0)
                ->get();

            $totalWeight = $cartItems->sum(fn($item) => $item->product->weight * $item->quantity);
            $shippingPrice = $totalWeight * $shipping->weight_price;
        }
        // شحن بناء علي المدينة
        elseif ($request->has('shipping_based_on_city') && $shipping->add_price_based_on_city == 1) {
            if ($request->has('user_address')) {
                $userAddress = UserAddress::find($request->user_address);
                if (!$userAddress) {
                    throw new \Exception('العنوان المحدد غير موجود. يرجى التحقق من صحة العنوان.', 400);
                }
                $cityId = $userAddress->city_id;
            } else {
                $cityId = $request->city_id;
            }
            $city = City::find($cityId);

            $shippingPrice = $city ? $city->shipping_price : 0;
        } else {
            throw new \Exception('تأكد من اختيارك طريقة شحن متاحة', 200);
        }

        return $shippingPrice;
    }

    public function createOrder($request, $user, $shippingPrice): Order
    {
        $settings = Setting::first();
        $valueAddedTax = $settings->value_added_tax ?? 0;

        $totalPrice = $this->calculateTotal($user);
        $totalBeforeDiscount = $this->calculateTotalBeforeDiscount($user);
        $addedTax = ($totalPrice * ($valueAddedTax / 100));

        return Order::create([
            'user_id' => $user->id,
            'payment_method' => $request->payment_method,
            'order_status_id' => OrderStatus::where('default_status', true)->first()->id,
            'note' => $request->note,
            'shipping_price' => $shippingPrice,
            'totalBeforeDiscount' => $totalBeforeDiscount,
            'total_price' => $totalPrice + $addedTax,
        ]);
    }
 
    public function createOrderItems($order, $user)
    {
        $cartItems = Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('status', 0)
            ->get();

        foreach ($cartItems as $cartItem) {
            $orderItem = OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product_id,
                'product_name' => $cartItem->product->name,
                'price' => $cartItem->product->discount_price ?? $cartItem->product->price,
                'quantity' => $cartItem->quantity,
            ]);

            if (!empty($cartItem->choices)) {
                foreach ($cartItem->choices as $choiceId) {
                    $orderItem->choices()->attach($choiceId); // لو فيه sub_choice كمان، زودها مع withPivot
                }
            }

            $cartItem->product->decrement('quantity', $cartItem->quantity);
        }
    }

    public function calculateTotal($user): float
    {
        //السعر بعد الخصم لو فيه خصم
        return Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)->where('status', 0)->get()
            ->sum(function ($item) {
                if ($item->product->discount_price) {
                    return $item->quantity * ($item->discounted_price ?? $item->product->discount_price);
                } else {
                    return $item->quantity * ($item->discounted_price ?? $item->product->price);
                }
            });
    }

    public function calculateTotalBeforeDiscount($user): float
    {
        return Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)->where('status', 0)->get()->sum(function ($item) {
                if ($item->product->discount_price) {
                    return $item->quantity * $item->product->discount_price;
                } else {
                    return $item->quantity * $item->product->price;
                }
            });
    }

    public function isAddingNewAddress($order, $request, $user)
    {
        $isAddingNewAddress = !$request->has('user_address');

        if ($isAddingNewAddress) {
            // هشحن ل عنوان جديد مش متسجل
            $addressData['type'] = 'shipping';
            $addressData['first_name'] = $request->first_name;
            $addressData['last_name'] = $request->last_name;
            $addressData['phone_number'] = $request->phone_number;
            $addressData['country_id'] = $request->country_id;
            $addressData['city_id'] = $request->city_id;
            $addressData['address'] = $request->address;
            $addressData['email'] = $user->email;
            $order->addresses()->create($addressData);
        }
        // هشحن ل عنوان متسجل
        else {
            $UserAddress = UserAddress::where('id', $request->user_address)->first();
            if ($UserAddress) {
                $address['first_name'] = $UserAddress->first_name;
                $address['last_name'] = $UserAddress->family_name;
                $address['phone_number'] = $UserAddress->phone_number;
                $address['country_id'] = $UserAddress->country_id;
                $address['city_id'] = $UserAddress->city_id;
                $address['address'] = $UserAddress->address;
                $address['email'] = $user->email;
                $order->addresses()->create($address);
            }
        }
    }

    public function getCartItems($user)
    {
        return Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('status', 0)->get();
    }

    public function disActiveProduct($cartItems)
    {
        foreach ($cartItems as $item) {
            $product = Product::where('id', $item->product_id)->first();
            if ($product->quantity <= 1) {
                $product->update([
                    'status' => 'archived'
                ]);
            }
        }
    }

    public function updateProductStatue($user)
    {
        Cart::withoutGlobalScope('cookie_id')->where('user_id', $user->id)
            ->where('status', 0)
            ->update(['status' => 1]);
    }

    public function sendNotificationToAdmin($order)
    {
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
    }

    public function checkPaymentMethod($request, $order)
    {
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
    }
}
