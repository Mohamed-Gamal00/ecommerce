<?php

namespace App\Repositories\Color;

use App\Helper\Helper;
use App\Models\Color;
use Illuminate\Support\Facades\Storage;

class ColorRepository implements ColorInterface
{
  use Helper;
  protected $color;

  public function __construct(Color $color)
  {
    $this->color = $color;
  }

  public function getMainColor(){
    return $this->color->paginate();
  }
  public function store($data){
    return $this->color->create($data);
  }

  public function update($data, $id){
    $color = $this->color->findOrFail($id);
    return $color->update($data);
  }

  public function delete($id){
    $color = $this->color::findOrFail($id);
    $color->delete();
  }
}
