<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ViewProductsResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LatestProductController extends Controller
{
    public function latestProducts()
    {
        $latestProducts = Product::latest()->take(5)->get();

        if (request()->hasHeader('user-id') && request()->hasHeader('guest-id')) {
            return ApiResponse::sendResponse(200, 'you must determind if you guest or user');
        }
        
        if (count($latestProducts) > 0) {
            return ApiResponse::sendResponse(200, 'Latest Products Retrieved Successfully', ViewProductsResource::collection($latestProducts));
        }
        return ApiResponse::sendResponse(200, 'No Products To Retrieved', []);
    }

    public function allLatestProducts()
    {
        $latestProducts = Product::latest()->paginate(10);


        if (count($latestProducts) > 0) {
            if ($latestProducts->total() > $latestProducts->perPage()) {
                $data = [
                    'records' => ViewProductsResource::collection($latestProducts),
                    'pagination links' => [
                        'current page' => $latestProducts->currentPage(),
                        'per page' => $latestProducts->perPage(),
                        'total' => $latestProducts->total(),
                        'links' => [
                            'first' => $latestProducts->url(1),
                            'last' => $latestProducts->url($latestProducts->lastPage())
                        ],
                    ],
                ];
            } else {
                $data = ViewProductsResource::collection($latestProducts);
            }
            return ApiResponse::sendResponse(200, 'Products Retrieved Successfully', $data);
        }
        return ApiResponse::sendResponse(200, 'No Products Available', []);
    }
}
