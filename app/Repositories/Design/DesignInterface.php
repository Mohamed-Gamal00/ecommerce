<?php

namespace App\Repositories\Design;

use App\Models\Design;
/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete ..
*/

interface DesignInterface
{
  public function getMainDesign();
  public function store($params);
  public function getById($id);
  public function update($params,$id);
  public function delete($id);
}
