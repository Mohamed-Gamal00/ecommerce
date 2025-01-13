<?php

namespace App\Repositories\Product;

interface ProductAvailabilityInterface
{
  public function getMainProductAvailability();
  public function store($params);
  public function getById($id);
  public function update($params,$id);
  public function delete($id);
}
