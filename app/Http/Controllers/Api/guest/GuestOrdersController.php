<?php

namespace App\Http\Controllers\Api\guest;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Guest;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class GuestOrdersController extends Controller
{
    public function mainOrders(Request $request)
    {
        $guest = $request->header('guest-id');
//        return $guest;
        $orders = Order::latest()
            ->with('products', 'orderStatus', 'orderItems', 'orderItems.product')
            ->where('guest_id', $guest)
            ->where('return_order', false)
            ->paginate(6);
//        return $orders;
        return response()->json([
            'orders' => OrderResource::collection($orders),

        ]);
    }

    public function showOrder(Request $request, $number)
    {
        $guest = $request->header('guest-id');
        $number = $request->header('number');
        if (!$number) {
            return response()->json([
                'message' => 'Order number is required in the header',
                'errors' => [
                    'number' => ['Order number is required.']
                ]
            ], 400); // Bad Request
        }

        $order = Order::latest()
            ->with('products', 'orderStatus', 'orderItems', 'orderItems.product')
            ->where('guest_id', $guest)
            ->where('return_order', false)
            ->where('number', $number)
            ->first();

        if (!$order) {
            return ApiResponse::sendResponse(200, 'الطلب غير موجود');
        }
//        return $order;
        $data = [
            'order' => new  OrderResource($order),
            'order status' => $order->orderStatus->getCurrentNameLangAttribute(),
        ];
        return ApiResponse::sendResponse(200, '', $data);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:order_items,product_id',
            'order_number' => 'required|string|exists:orders,number',
        ]);


        $order = Order::where('number', $request->order_number)->firstOrFail();
        $orderItem = $order->orderItems()->where('product_id', $request->product_id)->firstOrFail();

        if ($orderItem->quantity > 1) {
            $orderItem->decrement('quantity', 1);
        } else {
            $orderItem->delete();
        }

        // Recalculate the totals after the deletion
        $newTotalBeforeDiscount = $order->orderItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        $newTotalPrice = $order->orderItems->sum(function ($item) {
            return $item->quantity * ($item->discounted_price ?? $item->product->price);
        });

        // Update the order with the new totals
        $order->update([
            'totalBeforeDiscount' => $newTotalBeforeDiscount,
            'total_price' => $newTotalPrice,
        ]);

        // Check if the order has no remaining items and delete it if necessary
        if (!$order->orderItems()->exists()) {
            $order->delete();
        }
        return ApiResponse::sendResponse(200, 'تم الحذف بنجاح');
    }


    /*  المرتجعات  */
    public function returns(Request $request)
    {
        $guest_id = $request->header('guest-id');
//        return $guest_id;
        // Fetch user with related return products and orders with products
        $returnProducts = Guest::with('returnProducts', 'orders.products')
            ->where('id', $guest_id)
            ->first();

        if (!$returnProducts) {
            return response()->json(['message' => 'Guest or related data not found'], 404);
        }
        $finalOrderStatus = max(OrderStatus::pluck('arrangement')->toArray());
        $products = $returnProducts->orders()
            ->where('return_order', true)
            ->paginate(10);

        if ($products->isEmpty()) {
            return response()->json([
                'status_code' => 404,
                'message' => 'لا يوجد مرتجعات'
            ], 404);
        }


        // Return JSON response
        return response()->json([
            'status_code' => 200,
            'message' => 'success',
            'data' => [
//                'order_status' => $orderStatus, // Assuming OrderStatusResource for order statuses
                'products' => OrderResource::collection($products), // Assuming OrderResource is used for orders
            ]
        ]);
    }

    /*  make return order  */

    public function store(Request $request)
    {

        $statusId = OrderStatus::where('default_status', true)->first();

        if (!$statusId) {
            return response()->json(['status_code' => 400, 'message' => 'Default order status not found'], 400);
        }

        $request->validate([
            'return_order_id' => 'required',
        ]);

        // If return_order_id is provided, update the order to mark it as a return order
        if ($request->return_order_id) {
            $order = Order::where('id', $request->return_order_id)->first();

            if (!$order) {
                return response()->json(['status_code' => 404, 'message' => 'Order not found'], 404);
            }

            $order->update([
                'return_order' => true,
                'order_status_id' => $statusId->id
            ]);
        }
        return response()->json(['status_code' => 200, 'message' => 'تم ارجاع الطلب بنجاح']);

    }


}
