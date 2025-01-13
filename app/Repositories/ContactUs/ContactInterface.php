<?php

namespace App\Repositories\ContactUs;

interface ContactInterface
{
  public function getAll();
  public function show($id);
}
