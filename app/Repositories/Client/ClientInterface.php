<?php

namespace App\Repositories\Client;

interface ClientInterface
{
  public function getMainClient();
  public function updatePassword($params,$id);
  public function update($params,$id);
  public function delete($id);
}
