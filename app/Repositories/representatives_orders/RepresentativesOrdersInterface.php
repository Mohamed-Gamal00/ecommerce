<?php

namespace App\Repositories\representatives_orders;

interface RepresentativesOrdersInterface
{
  public function getAll();
  public function show($id);
  public function store(array $data);
  public function update(array $data, $id);
  public function delete($id);
}
