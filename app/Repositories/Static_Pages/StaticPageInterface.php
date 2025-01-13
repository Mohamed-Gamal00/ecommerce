<?php

namespace App\Repositories\Static_Pages;

interface StaticPageInterface
{
  public function getMainPages();
  public function update($params,$id);
}
