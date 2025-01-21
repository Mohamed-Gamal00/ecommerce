<?php

   namespace App\Http\Controllers\Api;

   use App\Helper\ApiResponse;
   use App\Http\Controllers\Controller;
   use App\Http\Resources\CountriesResource;
   use App\Models\Country;
   use Illuminate\Http\Request;

   class CountriesController extends Controller
   {
      public function allCountries()
      {
         $countries = Country::where('status', 'used')->get();

         if (count($countries) > 0) {
            return ApiResponse::sendResponse(200, 'Countries Retrieved Successfully', CountriesResource::collection($countries));
         }
         return ApiResponse::sendResponse(200, 'No Countries To Retrieved', []);
      }
   }