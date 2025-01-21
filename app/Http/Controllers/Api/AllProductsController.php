<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\FilterProductsResource;
use App\Http\Resources\ViewProductsResource;
use App\Models\Product;
use Illuminate\Http\Request;

class AllProductsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($category_id)
    {
        $allProducts = Product::with('parent', 'availability')
            ->where('category_id', $category_id)
            ->paginate(10);
        if (count($allProducts) > 0) {
            if ($allProducts->total() > $allProducts->perPage()) {
                $data = [
                    'records' => ViewProductsResource::collection($allProducts),
                    'pagination links' => [
                        'current page' => $allProducts->currentPage(),
                        'per page' => $allProducts->perPage(),
                        'total' => $allProducts->total(),
                        'links' => [
                            'first' => $allProducts->url(1),
                            'last' => $allProducts->url($allProducts->lastPage())
                        ],
                    ],
                ];
            } else {
                $data = ViewProductsResource::collection($allProducts);
            }
            return ApiResponse::sendResponse(200, 'Products Retrieved Successfully', $data);
        }
        return ApiResponse::sendResponse(200, 'No Products Available', []);
    }
}
