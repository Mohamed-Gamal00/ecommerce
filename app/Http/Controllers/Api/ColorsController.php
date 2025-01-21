<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\ColorsResource;
use App\Models\Color;
use Illuminate\Http\Request;

class ColorsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $colors = Color::has('products')->get();

        if (count($colors) > 0) {
            return ApiResponse::sendResponse(200, 'Colors Retrieved Successfully', ColorsResource::collection($colors));
        }
        return ApiResponse::sendResponse(200, 'No Colors Retrieved', []);
    }
}
