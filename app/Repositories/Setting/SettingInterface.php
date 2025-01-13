<?php

namespace App\Repositories\Setting;

interface SettingInterface
{

  public function getById($id);
  public function update($params,$id);
}
