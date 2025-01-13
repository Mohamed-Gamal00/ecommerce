<?php

namespace App\Repositories\common_questions;

use App\Helper\Helper;
use App\Models\CommonQuestion;
use Illuminate\Support\Facades\Storage;

class CommonQuestionsRepository implements CommonQuestionsInterface
{
  use Helper;

  protected $commonQuestion;

  public function __construct(CommonQuestion $commonQuestion)
  {
    $this->commonQuestion = $commonQuestion;
  }

  public function getMainCommon_questions()
  {
    return $this->commonQuestion->all();
  }


  public function store($data)
  {
    return $this->commonQuestion->create($data);
  }

  public function update($data, $id)
  {
    $question = $this->commonQuestion->findOrFail($id);
    $question->update($data);
    return $question;
  }
  public function delete($id)
  {
    $question = $this->commonQuestion->findOrFail($id);
    return $question->delete();
  }

}
