<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ViewProductsResource;
use App\Models\Guest;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddToFavProductsController extends Controller
{
    public function userAddFavProducts(Request $request)
    {
        $user = $request->user();
        $productId = $request->header('productId');

        if (!$productId || !Product::where('id', $productId)->exists()) {
            return ApiResponse::sendResponse(400, 'Product Doesn\'t Exist', []);
        }

        $result = $user->wishlistProducts()->toggle($productId);

        $message = count($result['attached']) > 0
            ? 'Product Added To Fav List Successfully'
            : 'Product Removed From Fav List';

            return ApiResponse::sendResponse(200, $message, []);
    }

    public function guestAddFavProducts(Request $request)
    {
        $guestId = $request->header('guest-id');
        $guest = Guest::where('id', $guestId)->first();
        $productId = $request->header('productId');
        $isExist = Product::where('id', $productId)->exists();

        if ($productId && $isExist) {
            if ($guest->wishlistProducts()->where('product_id', $productId)->exists()) {
                $guest->wishlistProducts()->detach($productId);
                return ApiResponse::sendResponse(200, 'Product Removed From Fav List', []);
            } else {
                $guest->wishlistProducts()->attach($productId);
                return ApiResponse::sendResponse(200, 'Product Added To Fav List Successfully', []);
            }
        }

        return ApiResponse::sendResponse(200, 'Product Doesn\'t Exists', []);
    }

    public function checkIfAuth(Request $request)
    {
        if ($request->user()) {
            return ApiResponse::sendResponse(200, true, []);
        }
        return ApiResponse::sendResponse(200, false, []);
    }
}
