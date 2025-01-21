<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\DiscountsResource;
use App\Http\Resources\ProductsResource;
use App\Http\Resources\ViewProductsResource;
use App\Models\Product;
use Illuminate\Http\Request;

class DiscountsController extends Controller
{
    public function discounts()
    {
        if (request()->hasHeader('user-id') && request()->hasHeader('guest-id')) {
            return ApiResponse::sendResponse(200, 'you must determind if you guest or user');
        }

        $discounts = Product::latest()->where('discount_price', '!=', null)
            ->orderBy('discount_price', 'desc')
            ->take(20)->get();

        if (count($discounts) > 0) {
            return ApiResponse::sendResponse(200, 'Products Retrieved Successfully', ViewProductsResource::collection($discounts));
        }
        return ApiResponse::sendResponse(200, 'No Products To Retrieved', []);
    }

    public function allDiscounts()
    {
        if (request()->hasHeader('user-id') && request()->hasHeader('guest-id')) {
            return ApiResponse::sendResponse(200, 'you must determind if you guest or user');
        }


        $discounts = Product::where('discount_price', '!=', null)
            ->orderBy('discount_price', 'desc')
            ->paginate(10);

        if (count($discounts) > 0) {
//            if ($discounts->total() > $discounts->perPage()) {
//                $data = [
//                    'records' => ViewProductsResource::collection($discounts),
//                    'pagination links' => [
//                        'current page' => $discounts->currentPage(),
//                        'per page' => $discounts->perPage(),
//                        'total' => $discounts->total(),
//                        'links' => [
//                            'first' => $discounts->url(1),
//                            'last' => $discounts->url($discounts->lastPage())
//                        ],
//                    ],
//                ];
//            }
//            else {
//                $data = ViewProductsResource::collection($discounts);
//            }
            $data = ViewProductsResource::collection($discounts);
            return ApiResponse::sendResponse(200, 'Products Retrieved Successfully', $data);
        }
        return ApiResponse::sendResponse(200, 'No Products Available', []);
    }
}
