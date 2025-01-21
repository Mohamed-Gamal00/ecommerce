<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\RepresentativesOrder;
use Illuminate\Http\Request;

class RepresentativeOrderController extends Controller
{
    public function storeorder(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create a new representatives order
        $representativesOrder = RepresentativesOrder::create($request->all());

        // Return a JSON response
        return ApiResponse::sendResponse(200, 'Order created successfully');

//        return response()->json([
//            'message' => 'Order created successfully',
//            'data' => $representativesOrder,
//        ], 201);
    }
}
