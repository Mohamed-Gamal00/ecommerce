<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\ProductsResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatus;
use App\Models\User;
use Illuminate\Http\Request;

class UserOrdersController extends Controller
{

    public function mainOrders(Request $request)
    {
        $user = $request->user();

        $orders = Order::latest()
            ->with('products', 'orderStatus', 'orderItems', 'orderItems.product')
            ->where('user_id', $user->id)
            ->where('return_order', false)
            ->has('orderItems')
            ->paginate(6);
        if ($orders) {
            return ApiResponse::sendResponse(200, '', OrderResource::collection($orders));
        } else {
            return ApiResponse::sendResponse(200, 'لا يوجد طلبات لعرضها');

        }

    }


    public function showOrder(Request $request, $number)
    {
        $user = $request->user();
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
            ->where('user_id', $user->id)
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

//        $orderItem = OrderItem::where('product_id', $request->product_id)->firstOrFail();
//        $order = Order::where('number', $request->order_number)->firstOrFail();
//
//        // Delete the order item
//        $orderItem->delete();

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
        $user = $request->user();

        // Fetch user with related return products and orders with products
        $returnProducts = User::with('returnProducts', 'orders.products')
            ->where('id', $user->id)
            ->first();

        if (!$returnProducts) {
            return response()->json(['message' => 'User or related data not found'], 404);
        }
        $finalOrderStatus = max(OrderStatus::pluck('arrangement')->toArray());
        $products = $returnProducts->orders()
            ->where('return_order', true)
            ->paginate(10);

        if ($products->isEmpty()) {
            return ApiResponse::sendResponse(200, 'لا يوجد مرتجعات');
        }


        // Return JSON response
        return response()->json([
            'status_code' => 200,
            'message' => 'User return products retrieved successfully',
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
//        return $statusId;

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
