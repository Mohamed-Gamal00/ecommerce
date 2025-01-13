<?php

namespace App\Repositories\store_featuers;

interface StoreInterface
{
  public function getfeatuers();
  public function store($data);
  public function getById($id);

  public function update($id,$data);
  public function delete($id);
}
