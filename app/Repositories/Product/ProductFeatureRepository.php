<?php

namespace App\Repositories\Product;

use App\Helper\Helper;

use App\Models\ProductFeature;


class ProductFeatureRepository implements ProudctFeatureInterface
{
  use Helper;

  protected $productFeature;

  public function __construct(ProductFeature $productFeature)
  {
    $this->productFeature = $productFeature;
  }

  public function deleteFeature($id)
  {
    $feature = $this->productFeature->find($id);
    if ($feature) {
      $feature->delete();
      return ['success' => true];
    } else {
      return ['success' => false, 'message' => 'Feature not found'];
    }
  }
}
