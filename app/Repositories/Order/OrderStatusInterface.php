<?php

namespace App\Repositories\Order;

interface OrderStatusInterface
{
  public function getAll();
  public function getById($id);
  public function store($data);
  public function update($data, $id);
  public function delete($id);
  public function getAllWithoutPagination();
  public function updateArrangement($statuses);

}
