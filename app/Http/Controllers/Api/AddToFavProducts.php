<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ViewProductsResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddToFavProducts extends Controller
{
    public function userFavProducts(Request $request)
    {
        $user = $request->user();
        $allFavProducts = DB::table('wishlist_products_user')->where('user_id', $user->id)->get();

        if (\count($allFavProducts) > 0) {
            return ApiResponse::sendResponse(200, 'User Favourite Products Retrieved Successfully', ViewProductsResource::collection($allFavProducts));
        }
        return ApiResponse::sendResponse(200, 'No Favourite Products To Retrieved', []);
    }
}
