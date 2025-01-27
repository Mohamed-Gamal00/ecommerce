<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsResource;
use App\Http\Resources\ViewProductsResource;
use App\Models\Guest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopSellingProductsController extends Controller
{
    public function topProducts()
    {
        if (request()->hasHeader('user-id') && request()->hasHeader('guest-id')) {
            return ApiResponse::sendResponse(200, 'you must determind if you guest or user');
        }


        $topSellingProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_quantity_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_quantity_sold')
            ->limit(20)
            ->get();

        if (count($topSellingProducts) > 0) {
            return ApiResponse::sendResponse(200, 'Top Selling Products Retrieved Successfully', ViewProductsResource::collection($topSellingProducts));
        }
        return ApiResponse::sendResponse(200, 'No Products To Retrieved', []);
    }

    public function allTopProducts()
    {
        if (request()->hasHeader('user-id') && request()->hasHeader('guest-id')) {
            return ApiResponse::sendResponse(200, 'you must determind if you guest or user');
        }

        // $topSellingProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_quantity_sold'))
        //     ->join('order_items', 'products.id', '=', 'order_items.product_id')
        //     ->groupBy('products.id')
        //     ->orderByDesc('total_quantity_sold')
        //     ->limit(50)
        //     ->paginate(10);

        $topSellingProducts = Product::select('products.*', 'sales.total_quantity_sold')
            ->joinSub(
                OrderItem::select('product_id', DB::raw('SUM(quantity) as total_quantity_sold'))
                    ->groupBy('product_id'),
                'sales',
                'products.id',
                '=',
                'sales.product_id'
            )
            ->orderByDesc('sales.total_quantity_sold')
            ->limit(50)
            ->paginate(10);


        if (count($topSellingProducts) > 0) {
            if ($topSellingProducts->total() > $topSellingProducts->perPage()) {
                $data = [
                    'records' => ViewProductsResource::collection($topSellingProducts),
                    'pagination links' => [
                        'current page' => $topSellingProducts->currentPage(),
                        'per page' => $topSellingProducts->perPage(),
                        'total' => $topSellingProducts->total(),
                        'links' => [
                            'first' => $topSellingProducts->url(1),
                            'last' => $topSellingProducts->url($topSellingProducts->lastPage())
                        ],
                    ],
                ];
            } else {
                $data = ViewProductsResource::collection($topSellingProducts);
            }
            return ApiResponse::sendResponse(200, 'Products Retrieved Successfully', $data);
        }
        return ApiResponse::sendResponse(200, 'No Products Available', []);
    }
}
