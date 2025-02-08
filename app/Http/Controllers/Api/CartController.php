<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartRequest;
use App\Models\Cart;
use App\Services\Cart\CartServices;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;
    public function __construct(CartServices $cart)
    {
        $this->cart = $cart;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        return $this->cart->fetchCartItems($user);
    }

    public function store(CartRequest $request)
    {
        // $user_id = auth()->user()->id;
        $user = $request->user();
        $data = $request->validated();
        return $this->cart->addProductToCart($data, $user);
    }

    public function destroy($id)
    {
        $cart = Cart::withoutGlobalScope('cookie_id')->findOrFail($id);
        return $this->cart->deleteCartItem($cart);
    }

    public function update(Request $request, $id)
    {
        return $this->cart->UpdateCartProductCount($request, $id);
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
