<?php

namespace App\Repositories\Profile;

interface ProfileSettingsInterface
{
  public function getProfile($id);
  public function changePassword($data, $id);
}
