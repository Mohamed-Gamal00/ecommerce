<?php

namespace App\Repositories\Color;

interface ColorInterface
{
  public function getMainColor();
  public function store($params);
  public function update($params,$id);
  public function delete($id);
}
