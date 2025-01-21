<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function createGuest(Request $request)
    {
        $guest = Guest::create();
        return ApiResponse::sendResponse(200, 'Guest Created Successfully', ['id' => $guest->id]);
    }
}
