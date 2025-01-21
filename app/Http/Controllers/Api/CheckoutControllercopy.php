<?php

namespace App\Http\Controllers\Api;

use App\Events\OrderCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Checkout\CheckoutRequest;
use App\Models\Admin;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\SendNewsToUser;
use App\Models\User;
use App\Models\UserAddress;
use App\Notifications\OrderCreatedEmailAdmin;
use App\Notifications\OrderCreatedNotification;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Symfony\Component\Intl\Countries;
use Throwable;

class CheckoutController extends Controller
{
    public function usercheckout(Request $request, Order $order)

    {
        $user = $request->user();
        $user_id = $user ? $user->id : null;
        $isAddingNewAddress = !$request->has('user_address');
        if ($user_id) {
            $request->validate([
                'user_address' => $isAddingNewAddress ? 'nullable' : 'required',
                'terms' => 'nullable',
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


//        return $request->all();
        $items = Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user_id)
            ->where('status', 0)->get();


        DB::beginTransaction();
        try {

            // store email to News if use checked join_news radio
            if ($request->join_news) {
                $user = User::find($user_id);
                $email = $user ? $user->email : null;
//                return $email;
                $existingEmail = SendNewsToUser::where('email', $email)->first();

                if (!$existingEmail) {
                    SendNewsToUser::create(['email' => $email]);
                }
            }


            $order = Order::create([
                'user_id' => $user_id,
                'payment_method' => 'cod', // cash on deleviry
                'order_status_id' => OrderStatus::select('id')->where('default_status', true)->first()->id,
                'note' => $request->note,
                'shipping_price' => request()->shipping == 'noShipping' ? null : $request->shipping_price,
                'totalBeforeDiscount' => 500,
                'total_price' => 300,
                'cookie_id' => $user_id ? null : Cart::getCookieId()
            ]);


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
                    'color' => $cart_items->color_id
                ]);


                $product = Product::withoutGlobalScope('cookie_id')->where('id', $item->product_id)->first();
                $decrementQuantity = Product::where('id', $item->product_id)->update([
                    'quantity' => $product->quantity - $item->quantity
                ]);
//                return $request->last_name;
                if ($isAddingNewAddress) {
                    $addressData['type'] = 'shipping';
                    $addressData['first_name'] = $request->first_name;
                    $addressData['last_name'] = $request->last_name;
                    $addressData['phone_number'] = $request->phone_number;
                    $addressData['country_id'] = $request->country_id;
                    $addressData['city_id'] = $request->city_id;
                    $addressData['address'] = $request->address;
                    $addressData['email'] = $user->email;
                    $order->addresses()->create($addressData);
                } else {
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

//                if ($request->user_address) {
//                    $user = User::find($user_id);
//                    $email = $user ? $user->email : null;
//                    $UserAddress = UserAddress::where('id', $request->user_address)
//                        ->first();
//                    $address['type'] = 'shipping';
//                    $address['first_name'] = $UserAddress->first_name ?? $request->addr['shipping']['first_name'];
//                    $address['last_name'] = $UserAddress->family_name ?? $request->addr['shipping']['last_name'];
//                    $address['phone_number'] = $UserAddress->phone_number ?? $request->addr['shipping']['phone_number'];
//                    $address['country_id'] = $UserAddress->country_id ?? $request->addr['shipping']['country_id'];
//                    $address['city_id'] = $UserAddress->city_id ?? $request->addr['shipping']['city_id'];
//                    $address['address'] = $UserAddress->address ?? $request->addr['shipping']['address'];
//                    $address['email'] = $email;
//
//                    $order->addresses()->create($address);
//                }
            }
//            return $items;
            foreach ($items as $item) {
                $product = Product::where('id', $item->product_id)->first();
                if ($product->quantity == 1) {
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

            $user = $order->addresses->first();

            // $user->notify(new SendOrderCreatedToUser($order));


            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        if ($user_id) {
            return response()->json(['message' => 'Order created successfully', 'order' => $order], 201);
        }
        return response()->json(['message' => 'Order creation failed', 'error' => $e->getMessage()], 500);
    }


}
