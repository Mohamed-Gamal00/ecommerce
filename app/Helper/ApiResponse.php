<?php

namespace App\Helper;

class ApiResponse
{
    static function sendResponse($status_code = 200, $msg = null, $data = null)
    {
        $response = [
            "status_code" => $status_code,
            "message" => $msg,
            "data" => $data,
        ];

        return response()->json($response, $status_code);

    }
}
