<?php

namespace App\Repositories\Product;

use App\Helper\Helper;
use App\Models\ProductAvailability;

class ProductAvailabilityRepository implements ProductAvailabilityInterface
{
  use Helper;

  protected $availability;

  public function __construct(ProductAvailability $productAvailability)
  {
    $this->availability = $productAvailability;
  }

  public function getMainProductAvailability()
  {
    return $this->availability->paginate();
  }

  public function getById($id)
  {
    return $this->availability->findOrFail($id);
  }

  public function store($data)
  {
    return $this->availability->create($data);
  }

  public function update($data, $id)
  {
    $availability = $this->availability->findOrFail($id);
    $availability->update($data);
    return $availability->wasChanged();
  }

  public function delete($id)
  {
    $availability = $this->availability->findOrFail($id);
    $availability->delete();
  }
}
