<?php

namespace App\Repositories\Category;

interface CategoryInterface
{
  public function getMainCategory();
  public function getAllMainCategoriesExcept($id);
  public function store($params);
  public function getById($id);
  public function update($params,$id);
  public function delete($id);
}
