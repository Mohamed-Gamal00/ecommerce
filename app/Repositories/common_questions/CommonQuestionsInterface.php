<?php

namespace App\Repositories\common_questions;

interface CommonQuestionsInterface
{
  public function getMainCommon_questions();
  public function update($params,$id);
  public function store($params);
  public function delete($params);
}
