<?php

namespace App\Repositories\Advertisement;

interface AdvertisementInterface
{
  public function getMainAdvertisemnt();
  public function store($params);
  public function update($params,$id);
  public function delete($id);
}
