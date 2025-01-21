<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\DefaultCurrencyResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CurrenciesController extends Controller
{
    public function defaultCurrency()
    {
        $defaultCurrency = DB::table('currencies')->where('default_currency', true)->first();

        if ($defaultCurrency) {
            return ApiResponse::sendResponse(200, 'Default Currency Retrieved Successfully', DefaultCurrencyResource::make($defaultCurrency));
        }
        return ApiResponse::sendResponse(200, 'There\'s No Default Currency Retrieved', []);


    }

    public function allCurrencies()
    {
        $allCurrencies = DB::table('currencies')->where('status', 'used')
                ->get();

        if ($allCurrencies) {
            return ApiResponse::sendResponse(200, 'Currencies Retrieved Successfully', CurrencyResource::collection($allCurrencies));
        }
        return ApiResponse::sendResponse(200, 'No Currencies To Retrieved', []);

    }
}