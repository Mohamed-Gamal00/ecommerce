<?php

namespace App\Repositories\Rule;

interface RuleInterface
{
  public function getAll();
  public function store($params);
  public function update($params, $id);
  public function delete($id);
}
