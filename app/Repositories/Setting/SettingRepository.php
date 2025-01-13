<?php

namespace App\Repositories\Setting;

use App\Helper\Helper;
use App\Models\Setting;

class SettingRepository implements SettingInterface
{
  use Helper;
  protected $color;

  public function __construct(Setting $color)
  {
    $this->color = $color;
  }

  public function getById($id)
  {
    return $this->color->findOrFail($id);
  }
  public function update($data, $id)
  {
    $settings = $this->color->findOrFail($id);
    // dd($data);
    $settings->update($data);
    return $settings->wasChanged();
  }
}
