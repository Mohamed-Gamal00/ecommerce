<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller

{
    public function index($order_number)
    {
        $order = Order::where('number', $order_number)->first();
        $publishable_key = Setting::all()->pluck('publishable_key')->first(); // This will get the first 'publishable_key' if present
        if ($order) {
            if ($order->payment_status == 'paid') {
                // Flash message to session
                session()->flash('success', 'This order has already been paid.');
            }

            return view('front.user-payment', compact('order', 'publishable_key'));
        } else {
            return "Order does not exist.";
        }
    }
    public function callback($number)
    {


        $order = Order::where('number', $number)->first();
        if ($order->payment_status == 'paid') {
            return redirect()->route('user.payment', [$order->number])->with('success', 'This order has already been paid');
        }
        if (!$order) {
            return redirect()->route('user.orders')->with('error', 'Order not found.');
        }
        $id = request()->query('id');
        $secret_key = Setting::all()->pluck('secret_key')->first();
        $token = base64_encode($secret_key . ':');

        $payment = Http::baseUrl('https://api.moyasar.com/v1')
            ->withHeaders([
                'Authorization' => "Basic {$token}",
            ])
            ->get("payments/{$id}")
            ->json();

        // Check if the response contains an authentication error
        if (isset($payment['type']) && $payment['type'] === 'authentication_error') {
            return redirect()->route('user.payment', [$number])
                ->with('danger', __('general.Invalid_authorization_credentials'));
        }
        //        dd($payment);
        if ($payment['status'] === 'paid') {
            $order->payment_status = 'paid';
            $order->save();


            if (Auth::guard('web')->check()) {
                return redirect()->route('user.orders', [$order->number])->with('success', 'عملية دفع ناجحة');
            } else {
                if ($order->guest_id != null || $order->user_id != null) {
                    return response()->json(['status' => 'success', 'message' => 'Payment successful', 'order_number' => $order->number], 200);
                } elseif ($order->cookie_id != null) {
                    return redirect()->route('guest.orders', [$order->number])->with('success', 'عملية دفع ناجحة');
                } else {
                    return response()->json(['status' => 'success', 'message' => 'no action', 'order_number' => $order->number], 200);
                }
            }
        } elseif ($payment['status'] === 'failed') {
            $order->payment_status = 'failed';
            $order->save();
            if (Auth::guard('web')->check()) {
                return redirect()->route('user.orders', [$order->number])->with('success', 'فشل عملية الدفع');
            } else {
                if ($order->guest_id != null || $order->user_id != null) {
                    return response()->json(['status' => 'success', 'message' => 'Payment faild', 'order_number' => $order->number], 200);
                } elseif ($order->cookie_id != null) {
                    return redirect()->route('guest.orders', [$order->number])->with('success', 'فشل عملية الدفع');
                } else {
                    return response()->json(['status' => 'success', 'message' => 'no action', 'order_number' => $order->number], 200);
                }
            }
        } else {
            return response()->json(['status' => 'success', 'message' => 'Payment failed', 'order_number' => $order->number], 200);
        }
    }
}
