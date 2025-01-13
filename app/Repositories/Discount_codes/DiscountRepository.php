<?php

namespace App\Repositories\Discount_codes;

use App\Helper\Helper;
use App\Models\DiscountCode;
use Illuminate\Support\Facades\Storage;

class DiscountRepository implements Discount_codesInterface
{
  use Helper;

  protected $discount_code;

  public function __construct(DiscountCode $discount_code)
  {
    $this->discount_code = $discount_code;
  }

  public function getMainDiscountCode()
  {
    return $this->discount_code->latest()->paginate();
  }

  public function store($data)
  {
    //  $this->discount_code->create($data); old
    return $this->discount_code->create($data);
  }

  public function update($data, $id)
  {
    $discountCode = $this->discount_code->findOrFail($id);
    $discountCode->update($data);
    return $discountCode->wasChanged();
  }

  /* new */
  public function syncProducts($discountCodeId, array $productIds)
  {
    $discountCode = $this->discount_code->findOrFail($discountCodeId);
    $discountCode->products()->sync($productIds);
  }

  public function delete($id)
  {
    $discountCode = $this->discount_code->findOrFail($id);
    $discountCode->delete();
  }
}
