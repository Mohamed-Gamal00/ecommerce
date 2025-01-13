<?php

namespace App\Repositories\Currency;

/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete ..
*/

interface CurrencyInterface
{
  public function getMainCurrency();
  public function getDefaultCurrency();
  public function store($params);
  public function getById($id);
  public function update($params,$id);
  public function delete($id);
  public function updateDefaultCurrency($params);
}
