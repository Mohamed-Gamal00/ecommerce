<?php

namespace App\Http\Controllers\Api;

use App\Helper\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
  public function settings()
  {
    $setting = Setting::first();

    if ($setting) {
      return ApiResponse::sendResponse(200, 'Setting Retrieved Successfully', new SettingResource($setting));
    }

    return ApiResponse::sendResponse(200, 'No Setting To Retrieve', []);
  }
}
