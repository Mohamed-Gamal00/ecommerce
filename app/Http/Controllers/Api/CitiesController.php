<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Models\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
  public function allCities()
  {
    $cities = City::where('country_id', '178')->get();

    if (count($cities) > 0) {
      return ApiResponse::sendResponse(200, 'cities Retrieved Successfully', CityResource::collection($cities));
    }
    return ApiResponse::sendResponse(200, 'No cities To Retrieved', []);
  }
}
