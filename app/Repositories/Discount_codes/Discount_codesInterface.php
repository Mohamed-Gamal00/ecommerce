<?php

namespace App\Repositories\Discount_codes;

interface Discount_codesInterface
{
  public function getMainDiscountCode();
  public function store($params);
  public function update($params,$id);
  public function delete($id);
}
