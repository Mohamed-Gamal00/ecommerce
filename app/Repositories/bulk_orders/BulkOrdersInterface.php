<?php

namespace App\Repositories\bulk_orders;

interface BulkOrdersInterface
{
  public function getAll();
  public function store(array $data);
  public function update(array $data, $id);
  public function delete($id);
}