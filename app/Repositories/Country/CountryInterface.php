<?php

namespace App\Repositories\Country;

/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete ..
*/

interface CountryInterface
{
  public function getMainCountry();
  public function store($params);
  public function getById($id);
  public function update($params,$id);
  public function delete($id);
}
