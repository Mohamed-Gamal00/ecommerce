<?php

namespace App\Repositories\Rule;

use App\Models\Rule;
use Illuminate\Http\Request;

class RuleRepository implements RuleInterface
{
  public function getAll()
  {
    return Rule::latest()->paginate();
  }
  public function store($data)
  {
    return Rule::createWithAbilies($data);
  }
  public function update($data, $id)
  {
    $rule = Rule::findOrFail($id);
    $rule->updateWithAbilies($data);
  }
  public function delete($id)
  {
    Rule::destroy($id);
  }
}
