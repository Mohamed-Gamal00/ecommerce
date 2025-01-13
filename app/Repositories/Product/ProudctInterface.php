<?php

namespace App\Repositories\Product;

interface ProudctInterface
{
  public function getMainProduct();
  public function store($params);
  public function getById($id);
  public function update($params,$id);
  public function delete($id);
}
