<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrandsResource;
use App\Models\Company;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $brands = Company::has('products')->get();

        if (count($brands) > 0) {
            return ApiResponse::sendResponse(200, 'Brands Retrieved Successfully', BrandsResource::collection($brands));
        }
        return ApiResponse::sendResponse(200, 'No Brands Retrieved', []);
    }
}
