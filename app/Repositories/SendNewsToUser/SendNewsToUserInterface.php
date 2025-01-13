<?php

namespace App\Repositories\SendNewsToUser;

interface SendNewsToUserInterface
{
  public function create();
  public function sendNewsMail($params);
}
