<?php

namespace App\Repositories\Company;

interface CompanyInterface
{
  public function getMainCompany();
  public function store($data);
  public function getById($id);

  public function update($id,$data);
  public function delete($id);
}
