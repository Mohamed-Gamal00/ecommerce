<?php

namespace App\Repositories\Static_Pages;

use App\Helper\Helper;
use App\Models\Page;
use Illuminate\Support\Facades\Storage;

class StaticPageRepository implements StaticPageInterface
{
  use Helper;

  protected $page;

  public function __construct(Page $page)
  {
    $this->page = $page;
  }

  public function getMainPages()
  {
    return $this->page->all();
  }


  public function update($data, $id)
  {
    $page = $this->page->findOrFail($id);
    $page->update($data);
    return $page->wasChanged();
  }

}
