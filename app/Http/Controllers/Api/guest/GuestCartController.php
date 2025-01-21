<?php

namespace App\Http\Controllers\Api\guest;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class GuestCartController extends Controller
{
    public function guestIndex(Request $request)
    {
        $guest_id = $request->header('guest-id');
//        return $guest_id;

        if (!$guest_id) {
            return response()->json(['error' => 'not found'], 401);
        }

        $cartItems = Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('guest_id', $guest_id)
            ->where('status', 0)->get();

        $totalCount = Cart::withoutGlobalScope('cookie_id')
            ->where('guest_id', $guest_id)
            ->where('status', 0)
            ->count();

        $TotalPrice = $cartItems->sum(function ($item) {
            return $item->quantity * ($item->discounted_price ?? $item->product->price);
        });

        $totalQuantity = Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('guest_id', $guest_id)
            ->where('status', 0)->get()->sum('quantity');

        $data = [
            'total_count' => $totalCount,
            'total_price' => $TotalPrice,
            'total_quantity' => $totalQuantity,
            'items' => CartResource::collection($cartItems),
        ];
        return ApiResponse::sendResponse(200, '', $data);

        return ApiResponse::sendResponse(200, 'لا توجد منتجات في السلة', []);

    }

    public function guestStore(Request $request)
    {
        $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color_id' => 'nullable|exists:colors,id', // Assuming you have a colors table
        ]);


        $guest_id = $request->guest_id;
        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $color_id = $request->color_id;

//        return $request->all();

        $item = Cart::where('product_id', '=', $product->id)->withoutGlobalScope('cookie_id')
            ->Where('guest_id', $guest_id)
            ->where('status', 0)
            ->first();
//        return $item;
        // Check if product is already in the cart
        if (!$item) {
            // Create new cart item
            $cart = Cart::create([
                'guest_id' => $guest_id,
                'product_id' => $product->id,
                'status' => 0,
                'quantity' => $quantity,
                'color_id' => $color_id,
            ]);

            return response()->json([
                'message' => 'Product added to cart successfully.',
                'cart' => $cart,
            ], 201);
        }

        // Check if requested quantity exceeds available product quantity
        if ($item->quantity + $quantity > $product->quantity) {
            return response()->json([
                'message' => 'Sorry, the requested quantity is not available.',
            ], 400);
        }

        // Increment the quantity of the existing cart item
        $item->increment('quantity', $quantity);

        return response()->json([
            'message' => 'Cart item quantity add successfully.',
            'cart' => $item,
        ], 200);
    }

    public function guestDestroy($id)
    {
        $cart = Cart::where('id', '=', $id)->withoutGlobalScope('cookie_id')
            ->update([
                'status' => 1
            ]);
        return ApiResponse::sendResponse(200, 'تم الحذف بنجاح', []);
    }

    public function guestUpdate(Request $request, $id)
    {
        $request->validate([
            'quantity' => ['required', 'int', 'min:1'],
        ]);
        Cart::where('id', '=', $id)->withoutGlobalScope('cookie_id')
            ->update([
                'quantity' => $request->post('quantity')
            ]);

        return ApiResponse::sendResponse(200, 'تم التعديل بنجاح', []);
    }


    public function totalBeforeDiscount(Request $request): float
    {
        $user_id = $request->user()->id;
        return Cart::with('product')->withoutGlobalScope('cookie_id')
            ->where('user_id', $user_id)
            ->where('status', 0)->get()
            ->sum(function ($item) {
                return $item->quantity * $item->product->price;
            });
    }
}
