<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\ProductFeature;
use App\Repositories\Product\ProductFeatureRepository;
use Illuminate\Http\Request;

class ProductsFeatures extends Controller
{

  protected $productFeatureRepository;

  public function __construct(ProductFeatureRepository $productFeatureRepository)
  {
    $this->productFeatureRepository = $productFeatureRepository;
  }

  public function deleteFeature(Request $request)
  {
    $featureId = $request->feature_id;
    $result = $this->productFeatureRepository->deleteFeature($featureId);

    if ($result['success']) {
      return response()->json(['success' => true], 200);
    } else {
      return response()->json(['success' => false, 'message' => $result['message']], 404);
    }
  }
}
