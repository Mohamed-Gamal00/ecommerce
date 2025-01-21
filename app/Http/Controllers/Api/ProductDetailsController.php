<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductColorsResource;
use App\Http\Resources\ProductDetailsResource;
use App\Http\Resources\ProductTypesResource;
use App\Http\Resources\ViewProductsResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductDetailsController extends Controller
{

    public function getProductDetails($id)
    {
        if (request()->hasHeader('user-id') && request()->hasHeader('guest-id')) {
            return ApiResponse::sendResponse(200, 'you must determind if you guest or user');
        }
        $product = Product::find($id);

        if ($product) {
            return ApiResponse::sendResponse(200, 'Product Details Retrieved Successfully', ProductDetailsResource::make($product));
        }

        return ApiResponse::sendResponse(200, 'Product Doesn\'t Exists', []);
    }


    # TODO:: Remember to return here after edit the database
    public function productFeatures($id)
    {
        if (request()->hasHeader('user-id') && request()->hasHeader('guest-id')) {
            return ApiResponse::sendResponse(200, 'you must determind if you guest or user');
        }

        $product = Product::find($id);

        if (!$product) {
            return ApiResponse::sendResponse(200, 'Product Doesn\'t  Exists', []);

        }

        if ($product && $product->features->first()) {

            return ApiResponse::sendResponse(200, 'Product Features Retrieved Successfully', ProductTypesResource::collection($product->features));
        }

        return ApiResponse::sendResponse(200, 'Product Doesn\'t Have Features', []);

    }

    public function relatedProducts($id)
    {
        if (request()->hasHeader('user-id') && request()->hasHeader('guest-id')) {
            return ApiResponse::sendResponse(200, 'you must determind if you guest or user');
        }
        $product = Product::find($id);

        if (!$product) {
            return ApiResponse::sendResponse(200, 'Product Doesn\'t  Exists', []);
        }

        $relatedProducts = Product::where('category_id', $product->category_id)->take(10)->get();

        if (count($relatedProducts) > 0) {
            return ApiResponse::sendResponse(200, 'Related Products Retrieved Successfully', ViewProductsResource::collection($relatedProducts));
        }
        return ApiResponse::sendResponse(200, 'No Related Products To Retrieved', []);


    }
}
