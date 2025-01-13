<?php

namespace App\Repositories\City;

/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete ..
*/

interface CityInterface
{
  public function getMainCity();
  public function store($params);
  public function getById($id);
  public function update($params,$id);
  public function delete($id);
}
