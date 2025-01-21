<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\FilterProductsResource;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchProductController extends Controller
{
    public function search(Request $request)
    {
        $word = $request->has('product_name') ? $request->input('product_name') : null;
        $products = Product::when($word != null, function ($query) use ($word) {
            $query->where('name', 'LIKE', '%' . $word . '%');
        })->latest()->get();


        if (count($products) > 0) {
            return ApiResponse::sendResponse(200, 'Search Completed', FilterProductsResource::collection($products));
        }
        return ApiResponse::sendResponse(200, 'No Matching Data', []);
    }

}
