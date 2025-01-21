<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\FilterProductsResource;
use App\Http\Resources\ViewProductsResource;
use App\Models\Color;
use App\Models\Company;
use App\Models\MainCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class FilterProductsController extends Controller
{
    public function filterProducts(Request $request)
    {
        $filter = $request->all();
        $query = Product::query();

        if (isset($request->rate_number) && !is_null($request->rate_number)) {
            $query->whereHas('comments', function ($query) use ($request) {
                $query->where('rate', $request->rate_number);
            });

        }

        if (isset($request->category_id) && !is_null($request->category_id)) {
            $query->where('category_id', $request->category_id);
        }

        if (isset($request->company_id) && !is_null($request->company_id)) {
            $query->where('company_id', $request->company_id);

        }

        if (isset($request->price_min) && !is_null($request->price_min)) {
            $query->where('price', '>=', $request->price_min);
        }

        if (isset($request->price_max) && !is_null($request->price_max)) {
            $query->where('price', '<=', $request->price_max);
        }

        if (isset($request->color_id) && !is_null($request->color_id)) {
            $query->whereHas('colors', function ($query) use ($request) {
                $query->where('color_id', $request->color_id);
            });

        }
        

        $productsQuery = $query->where('status', 'active');

        if ($request->filled('category_id')) {
            $productsQuery->where('category_id', $request->category_id);
        }

        $products = $productsQuery->latest()->paginate(10);

        if (count($products) > 0) {
            if ($products->total() > $products->perPage()) {
                $data = [
                    'records' => FilterProductsResource::collection($products),
                    'pagination links' => [
                        'current page' => $products->currentPage(),
                        'per page' => $products->perPage(),
                        'total' => $products->total(),
                        'links' => [
                            'first' => $products->url(1),
                            'last' => $products->url($products->lastPage())
                        ],
                    ],
                ];
            } else {
                $data = FilterProductsResource::collection($products);
            }
            return ApiResponse::sendResponse(200, 'Filtering Successfully', $data);
        }
        return ApiResponse::sendResponse(200, 'No Products Available', []);

    }
}
