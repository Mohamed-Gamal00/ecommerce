<?php

namespace App\Repositories\Design;

use App\Helper\Helper;

use App\Models\Design;
use Illuminate\Support\Facades\Storage;

/*
    Separates databases layer from services layer
    contain all databse work
    handel the database operation as create update delete ..
*/

class DesignRepository implements DesignInterface
{

  use Helper;
  public $design;
  public function __construct(Design $design)
  {
    $this->design = $design;  // Ready-instance model of Design
  }

  public function getMainDesign()
  {
    return $this->design::orderByRaw('main_banar IS NULL, main_banar ASC')->paginate();
  }
  public function getHomeBanners()
  {
    return $this->design->where('page_name', 'home')->get();
  }
  public function getOfferBageBanners()
  {
    return $this->design->where('page_name', 'offers-page')->get();
  }

  public function store($data)
  {
    return $this->design->create($data);
  }

  public function getById($id)
  {
    return $this->design->findOrFail($id);
  }

  public function update($data,$id)
  {
    $design = $this->getById($id);
    $design->update($data);

    return $design->wasChanged();
  }

  public function delete($id)
  {
    $design = $this->design->findOrFail($id);
    $design->delete();
  }
}
