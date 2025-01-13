<?php

namespace App\Repositories\Profile;

interface ProfileInterface
{
  public function getProfile($id);
  public function updateProfile($params, $id);
}
