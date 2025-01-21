<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Http\Request;

class UserAuthecticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
      dd($request->all());
        // $validate = $request->validated();

        // if ($validate->fails()) {
        //     return ApiResponse::sendResponse(422, 'Register Validation Error', $validate->errors());
        // }
    }
}
