<?php

namespace App\Services\Cart;

use App\Helper\ApiResponse;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;

class CartServices
{
    public function fetchCartItems($user)
    {
        if ($user) {
            $cartItems = Cart::with('product')->withoutGlobalScope('cookie_id')
                ->where('user_id', $user->id)
                ->where('status', 0)->get();

            $totalCount = $cartItems->count();

            $totalQuantity = $cartItems->sum('quantity');

            $TotalPrice = $cartItems->sum(function ($item) {
                return $item->quantity * ($item->product->discount_price ?? $item->product->price);
            });

            $discounted_price = $cartItems->first()->discounted_price ?? 0;
        }

        $data = [
            'total_count' => $totalCount,
            'discounted_price' => $discounted_price,  //  قيمة الخصم علي المنتج الواحد
            'total_price' => $TotalPrice,
            'total_quantity' => $totalQuantity,
            'items' => CartResource::collection($cartItems),
        ];
        return ApiResponse::sendResponse(200, '', $data);
    }

    public function addProductToCart(array $data, $user)
    {
        $product = Product::findOrFail($data['product_id']);
        $quantity = $data['quantity'];

        // Check if requested quantity is available
        if ($quantity > $product->quantity) {
            return ApiResponse::sendResponse(400, "Sorry, the requested quantity is not available.");
        }

        // Check if product is already in the cart
        $cartItem = Cart::withoutGlobalScope('cookie_id')
            ->where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->where('status', 0)
            ->first();

        if ($cartItem) {
            // Ensure adding more quantity does not exceed available stock
            if (($cartItem->quantity + $quantity) > $product->quantity) {
                return ApiResponse::sendResponse(400, "Sorry, the requested quantity exceeds available stock.");
            }

            // Increment the quantity of the existing cart item
            $cartItem->increment('quantity', $quantity);

            return ApiResponse::sendResponse(200, "Cart item quantity updated successfully.", $cartItem);
        }

        // Create new cart item if not found
        $cart = Cart::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'status' => 0,
            'quantity' => $quantity,
        ]);

        return ApiResponse::sendResponse(201, "Product added to cart successfully.", $cart);
    }

    public function deleteCartItem($cart)
    {
        if (!$cart) {
            return ApiResponse::sendResponse(404, 'المنتج غير موجود في السلة', []);
        }
        $cart->update([
            'status' => 1
        ]);

        return ApiResponse::sendResponse(200, 'success', []);
    }

    public function UpdateCartProductCount($request,$id)
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
}
