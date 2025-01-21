<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Front\bullkorder\BulkRequest;
use App\Models\BulkOrder;
use Illuminate\Http\Request;

class BulkOrderController extends Controller
{
    public function store(BulkRequest $request)
    {
        $bulkOrder = BulkOrder::create($request->all());

        return ApiResponse::sendResponse(200, 'Order created successfully');
    }
}
