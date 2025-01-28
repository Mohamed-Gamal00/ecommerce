<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{

    public function index(Request $request)
    {
        $user = $request->user();
//        return $user;
//        $user_id = $user ? $user->id : null;

        if ($user) {
            $cartItems = Cart::with('product')->withoutGlobalScope('cookie_id')
                ->where('user_id', $user->id)
                ->where('status', 0)->get();

            $totalCount = Cart::withoutGlobalScope('cookie_id')
                ->where('user_id', $user->id)
                ->where('status', 0)
                ->count();

            $TotalPrice = $cartItems->sum(function ($item) {
                return $item->quantity * ($item->product->discount_price ?? $item->product->price);
            });

//            // Calculate total price of products without discounts
//            $TotalPriceWithoutDiscount = $cartItems->sum(function ($item) {
//                // Only sum products that do not have a discount_price
//                return is_null($item->product->discount_price)
//                    ? $item->quantity * $item->product->price
//                    : 0;
//            });

//            $TotalPrice = $TotalPriceWithDiscount + $TotalPriceWithoutDiscount;

            $discounted_price = Cart::withoutGlobalScope('cookie_id')
                ->where('user_id', $user->id)
                ->where('status', 0)
                ->value('discounted_price');

            $totalQuantity = Cart::with('product')->withoutGlobalScope('cookie_id')
                ->where('user_id', $user->id)
                ->where('status', 0)->get()->sum('quantity');
        }

//        $data = $cartItems;
//        return $data;
        $data = [
            'total_count' => $totalCount,
            'discounted_price' => $discounted_price,  // قيمة الخصم علي المنتج
            'total_price' => $TotalPrice,
            'total_quantity' => $totalQuantity,
            'items' => CartResource::collection($cartItems) ?? null,
        ];
        return ApiResponse::sendResponse(200, '', $data);


//        return ApiResponse::sendResponse(200, 'لا توجد منتجات في السلة', []);
    }


    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $request->validate([
//            'user_id' => 'nullable|exists:users,id',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'color_id' => 'nullable|exists:colors,id', // Assuming you have a colors table
        ]);

        $product = Product::findOrFail($request->product_id);
        $quantity = $request->quantity;
        $color_id = $request->color_id;

//        return $request->all();

        if ($quantity > $product->quantity) {
            return response()->json([
                'message' => 'Sorry, the requested quantity is not available.',
            ], 400);
        }

        $item = Cart::where('product_id', '=', $product->id)->withoutGlobalScope('cookie_id')
            ->where('user_id', $user_id)
            ->where('status', 0)
            ->first();

//        return $item;
        // Check if product is already in the cart
        if (!$item) {
            // Create new cart item
            $cart = Cart::create([
                'user_id' => $user_id,
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
            'message' => 'Cart item quantity added successfully.',
            'cart' => $item,
        ], 200);
    }

    public function destroy($id)
    {
        $cart = Cart::withoutGlobalScope('cookie_id')->findOrFail($id);
//        return $cart;
        if (!$cart) {
            return ApiResponse::sendResponse(404, 'المنتج غير موجود في السلة', []);
        }
        $cart->update([
            'status' => 1
        ]);

        return ApiResponse::sendResponse(200, 'تم الحذف بنجاح', []);
    }

    public function update(Request $request, $id)
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
